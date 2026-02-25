CREATE DATABASE IF NOT EXISTS mlm_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mlm_platform;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mobile VARCHAR(20) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    referral_code VARCHAR(30) NOT NULL UNIQUE,
    referred_by_user_id BIGINT UNSIGNED NULL,
    otp_verified_at DATETIME NULL,
    kyc_status ENUM('NOT_SUBMITTED','PENDING','VERIFIED','REJECTED') NOT NULL DEFAULT 'NOT_SUBMITTED',
    status ENUM('ACTIVE','BLOCKED','PENDING_VERIFICATION') NOT NULL DEFAULT 'ACTIVE',
    registered_at DATETIME NOT NULL,
    last_login_at DATETIME NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_users_referred_by FOREIGN KEY (referred_by_user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE admin (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    role ENUM('SUPER_ADMIN','FINANCE_ADMIN','SUPPORT_ADMIN') NOT NULL DEFAULT 'SUPER_ADMIN',
    is_2fa_enabled TINYINT(1) NOT NULL DEFAULT 0,
    can_manage_plans TINYINT(1) NOT NULL DEFAULT 1,
    can_manage_withdrawals TINYINT(1) NOT NULL DEFAULT 1,
    can_manage_income_rules TINYINT(1) NOT NULL DEFAULT 1,
    can_manage_security_settings TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_admin_user FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE plans (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(80) NOT NULL,
    id_price DECIMAL(12,2) NOT NULL,
    validity_days SMALLINT UNSIGNED NOT NULL,
    daily_task_income DECIMAL(12,2) NOT NULL,
    referral_daily_income DECIMAL(12,2) NOT NULL,
    referral_one_time_bonus DECIMAL(12,2) NOT NULL,
    minimum_withdrawal DECIMAL(12,2) NOT NULL,
    max_withdrawal_per_week DECIMAL(12,2) NULL,
    task_time_limit_minutes INT UNSIGNED NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    apply_income_updates_to_active_users TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE plan_task_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    plan_id BIGINT UNSIGNED NOT NULL,
    task_title VARCHAR(150) NOT NULL,
    task_type ENUM('VIDEO','FORM','QUIZ','VISIT_PAGE','CUSTOM') NOT NULL,
    instructions TEXT NULL,
    reward_amount DECIMAL(12,2) NOT NULL,
    start_time TIME NULL,
    end_time TIME NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_plan_task_templates_plan FOREIGN KEY (plan_id) REFERENCES plans(id)
) ENGINE=InnoDB;

CREATE TABLE user_plans (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    plan_id BIGINT UNSIGNED NOT NULL,
    amount_paid DECIMAL(12,2) NOT NULL,
    payment_reference VARCHAR(120) NOT NULL,
    payment_verified_at DATETIME NULL,
    activated_at DATETIME NOT NULL,
    expires_at DATETIME NOT NULL,
    status ENUM('ACTIVE','EXPIRED','CANCELLED') NOT NULL DEFAULT 'ACTIVE',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_user_plans_user_status (user_id, status),
    CONSTRAINT fk_user_plans_user FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_user_plans_plan FOREIGN KEY (plan_id) REFERENCES plans(id)
) ENGINE=InnoDB;

CREATE TABLE daily_tasks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_plan_id BIGINT UNSIGNED NOT NULL,
    plan_task_template_id BIGINT UNSIGNED NULL,
    task_date DATE NOT NULL,
    task_status ENUM('PENDING','COMPLETED','MISSED') NOT NULL DEFAULT 'PENDING',
    completed_at DATETIME NULL,
    income_credited DECIMAL(12,2) NOT NULL DEFAULT 0,
    income_credit_txn_id BIGINT UNSIGNED NULL,
    is_settled TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uq_task_per_day (user_plan_id, task_date),
    INDEX idx_daily_tasks_status (task_status, task_date),
    CONSTRAINT fk_daily_tasks_user_plan FOREIGN KEY (user_plan_id) REFERENCES user_plans(id),
    CONSTRAINT fk_daily_tasks_template FOREIGN KEY (plan_task_template_id) REFERENCES plan_task_templates(id)
) ENGINE=InnoDB;

CREATE TABLE referrals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sponsor_user_id BIGINT UNSIGNED NOT NULL,
    referred_user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    referred_plan_id BIGINT UNSIGNED NULL,
    qualified_at DATETIME NULL,
    daily_income_active TINYINT(1) NOT NULL DEFAULT 1,
    daily_income_cap_amount DECIMAL(12,2) NULL,
    one_time_bonus_credited TINYINT(1) NOT NULL DEFAULT 0,
    one_time_bonus_txn_id BIGINT UNSIGNED NULL,
    last_daily_income_date DATE NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_referrals_sponsor (sponsor_user_id),
    CONSTRAINT fk_referrals_sponsor FOREIGN KEY (sponsor_user_id) REFERENCES users(id),
    CONSTRAINT fk_referrals_referred FOREIGN KEY (referred_user_id) REFERENCES users(id),
    CONSTRAINT fk_referrals_plan FOREIGN KEY (referred_plan_id) REFERENCES user_plans(id)
) ENGINE=InnoDB;

CREATE TABLE lucky_wheel_rewards (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reward_label VARCHAR(50) NOT NULL,
    reward_amount DECIMAL(12,2) NOT NULL,
    probability_weight INT UNSIGNED NOT NULL,
    max_win_per_day INT UNSIGNED NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE user_spin_ledger (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    referral_id BIGINT UNSIGNED NULL,
    unlocked_spins INT UNSIGNED NOT NULL DEFAULT 0,
    consumed_spins INT UNSIGNED NOT NULL DEFAULT 0,
    available_spins INT UNSIGNED NOT NULL DEFAULT 0,
    updated_at DATETIME NOT NULL,
    UNIQUE KEY uq_user_spin_ledger_user (user_id),
    CONSTRAINT fk_spin_ledger_user FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_spin_ledger_referral FOREIGN KEY (referral_id) REFERENCES referrals(id)
) ENGINE=InnoDB;

CREATE TABLE lucky_wheel_spins (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    referral_id BIGINT UNSIGNED NULL,
    reward_id BIGINT UNSIGNED NOT NULL,
    reward_amount DECIMAL(12,2) NOT NULL,
    spin_status ENUM('PENDING','COMPLETED','REVERSED') NOT NULL DEFAULT 'COMPLETED',
    spun_at DATETIME NOT NULL,
    reward_txn_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    INDEX idx_wheel_user (user_id, spun_at),
    CONSTRAINT fk_lucky_spin_user FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_lucky_spin_referral FOREIGN KEY (referral_id) REFERENCES referrals(id),
    CONSTRAINT fk_lucky_spin_reward FOREIGN KEY (reward_id) REFERENCES lucky_wheel_rewards(id)
) ENGINE=InnoDB;

CREATE TABLE wallets (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    task_income_balance DECIMAL(14,2) NOT NULL DEFAULT 0,
    referral_income_balance DECIMAL(14,2) NOT NULL DEFAULT 0,
    lucky_wheel_income_balance DECIMAL(14,2) NOT NULL DEFAULT 0,
    withdrawable_balance DECIMAL(14,2) NOT NULL DEFAULT 0,
    total_earned DECIMAL(14,2) NOT NULL DEFAULT 0,
    total_withdrawn DECIMAL(14,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_wallet_user FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    source_type ENUM('PLAN_PURCHASE','TASK_INCOME','REFERRAL_DAILY','REFERRAL_BONUS','LUCKY_WHEEL','WITHDRAWAL','MANUAL_CREDIT','MANUAL_DEBIT') NOT NULL,
    source_id BIGINT UNSIGNED NULL,
    wallet_segment ENUM('TASK','REFERRAL','LUCKY_WHEEL','WITHDRAWABLE') NOT NULL,
    txn_type ENUM('CREDIT','DEBIT') NOT NULL,
    amount DECIMAL(14,2) NOT NULL,
    balance_after DECIMAL(14,2) NULL,
    status ENUM('PENDING','SUCCESS','FAILED','REVERSED') NOT NULL DEFAULT 'SUCCESS',
    idempotency_key VARCHAR(120) NULL,
    meta JSON NULL,
    created_at DATETIME NOT NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_transactions_user_created (user_id, created_at),
    UNIQUE KEY uq_transactions_idempotency (idempotency_key),
    CONSTRAINT fk_transactions_user FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE withdrawal_cycles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    cycle_start_date DATE NOT NULL,
    cycle_end_date DATE NOT NULL,
    requests_count INT UNSIGNED NOT NULL DEFAULT 0,
    approved_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uq_withdrawal_cycle (user_id, cycle_start_date),
    CONSTRAINT fk_withdrawal_cycles_user FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE withdrawals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    user_id BIGINT UNSIGNED NOT NULL,
    user_plan_id BIGINT UNSIGNED NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    fee_percent DECIMAL(5,2) NOT NULL DEFAULT 0,
    fee_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    net_amount DECIMAL(12,2) NOT NULL,
    minimum_required DECIMAL(12,2) NOT NULL,
    payout_mode ENUM('UPI','BANK') NOT NULL,
    payout_account VARCHAR(191) NOT NULL,
    request_status ENUM('PENDING','APPROVED','REJECTED','PAID') NOT NULL DEFAULT 'PENDING',
    requested_at DATETIME NOT NULL,
    reviewed_by_admin_id BIGINT UNSIGNED NULL,
    reviewed_at DATETIME NULL,
    rejected_reason VARCHAR(255) NULL,
    paid_at DATETIME NULL,
    withdrawal_txn_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_withdrawals_user_requested (user_id, requested_at),
    CONSTRAINT fk_withdrawals_user FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_withdrawals_user_plan FOREIGN KEY (user_plan_id) REFERENCES user_plans(id),
    CONSTRAINT fk_withdrawals_admin FOREIGN KEY (reviewed_by_admin_id) REFERENCES admin(id)
) ENGINE=InnoDB;

CREATE TABLE system_settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `group` VARCHAR(50) NOT NULL,
    `key` VARCHAR(80) NOT NULL,
    `value` TEXT NOT NULL,
    data_type ENUM('STRING','INTEGER','BOOLEAN','JSON') NOT NULL DEFAULT 'STRING',
    is_editable TINYINT(1) NOT NULL DEFAULT 1,
    updated_by_admin_id BIGINT UNSIGNED NULL,
    updated_at DATETIME NOT NULL,
    UNIQUE KEY uq_system_settings (`group`, `key`),
    CONSTRAINT fk_system_settings_admin FOREIGN KEY (updated_by_admin_id) REFERENCES admin(id)
) ENGINE=InnoDB;

CREATE TABLE audit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    actor_type ENUM('USER','ADMIN','SYSTEM') NOT NULL,
    actor_id BIGINT UNSIGNED NULL,
    action VARCHAR(120) NOT NULL,
    entity_type VARCHAR(120) NOT NULL,
    entity_id VARCHAR(64) NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    before_state JSON NULL,
    after_state JSON NULL,
    created_at DATETIME NOT NULL,
    INDEX idx_audit_entity (entity_type, entity_id)
) ENGINE=InnoDB;

ALTER TABLE daily_tasks
    ADD CONSTRAINT fk_daily_tasks_txn FOREIGN KEY (income_credit_txn_id) REFERENCES transactions(id);

ALTER TABLE referrals
    ADD CONSTRAINT fk_referrals_bonus_txn FOREIGN KEY (one_time_bonus_txn_id) REFERENCES transactions(id);

ALTER TABLE lucky_wheel_spins
    ADD CONSTRAINT fk_lucky_spin_txn FOREIGN KEY (reward_txn_id) REFERENCES transactions(id);

ALTER TABLE withdrawals
    ADD CONSTRAINT fk_withdrawals_txn FOREIGN KEY (withdrawal_txn_id) REFERENCES transactions(id);

INSERT INTO plans (code, name, id_price, validity_days, daily_task_income, referral_daily_income, referral_one_time_bonus, minimum_withdrawal, max_withdrawal_per_week, task_time_limit_minutes, is_active, apply_income_updates_to_active_users, created_at, updated_at)
VALUES
('SILVER', 'Silver Plan', 1800.00, 90, 50.00, 5.00, 160.00, 400.00, 5000.00, 1440, 1, 0, NOW(), NOW()),
('GOLD', 'Gold Plan', 4200.00, 90, 120.00, 10.00, 340.00, 850.00, 12000.00, 1440, 1, 0, NOW(), NOW()),
('DIAMOND', 'Diamond Plan', 7400.00, 90, 230.00, 25.00, 780.00, 1200.00, 25000.00, 1440, 1, 0, NOW(), NOW());

INSERT INTO lucky_wheel_rewards (reward_label, reward_amount, probability_weight, max_win_per_day, is_active, created_at, updated_at)
VALUES
('₹5', 5.00, 250, NULL, 1, NOW(), NOW()),
('₹10', 10.00, 220, NULL, 1, NOW(), NOW()),
('₹56', 56.00, 180, NULL, 1, NOW(), NOW()),
('₹97', 97.00, 130, NULL, 1, NOW(), NOW()),
('₹109', 109.00, 100, NULL, 1, NOW(), NOW()),
('₹222', 222.00, 70, NULL, 1, NOW(), NOW()),
('₹555', 555.00, 35, NULL, 1, NOW(), NOW()),
('₹1200', 1200.00, 15, NULL, 1, NOW(), NOW());

INSERT INTO system_settings (`group`, `key`, `value`, data_type, is_editable, updated_at)
VALUES
('platform', 'site_name', 'MLM Software', 'STRING', 1, NOW()),
('platform', 'maintenance_mode', 'false', 'BOOLEAN', 1, NOW()),
('security', 'max_accounts_per_ip', '2', 'INTEGER', 1, NOW()),
('security', 'kyc_required', 'false', 'BOOLEAN', 1, NOW()),
('security', 'anti_fake_referral_enabled', 'true', 'BOOLEAN', 1, NOW()),
('income', 'daily_settlement_enabled', 'true', 'BOOLEAN', 1, NOW()),
('income', 'task_system_enabled', 'true', 'BOOLEAN', 1, NOW()),
('income', 'task_cutoff_hour_24h', '23', 'INTEGER', 1, NOW()),
('income', 'referral_system_enabled', 'true', 'BOOLEAN', 1, NOW()),
('income', 'referral_max_daily_payout', '0', 'STRING', 1, NOW()),
('withdrawal', 'enabled', 'true', 'BOOLEAN', 1, NOW()),
('withdrawal', 'cycle_days', '7', 'INTEGER', 0, NOW()),
('withdrawal', 'weekly_request_limit', '1', 'INTEGER', 0, NOW()),
('withdrawal', 'fee_percent', '0', 'STRING', 1, NOW()),
('withdrawal', 'auto_approval_enabled', 'false', 'BOOLEAN', 1, NOW()),
('lucky_wheel', 'enabled', 'true', 'BOOLEAN', 1, NOW()),
('lucky_wheel', 'spins_per_qualified_referral', '1', 'INTEGER', 0, NOW()),
('lucky_wheel', 'max_spins_per_day', '10', 'INTEGER', 1, NOW());
