const express = require('express');
const { body, validationResult } = require('express-validator');
const pool = require('../config/db');
const router = express.Router();

const siteData = async () => {
  const [categories] = await pool.query('SELECT * FROM categories ORDER BY name');
  const [contactRows] = await pool.query('SELECT * FROM contact_info LIMIT 1');
  const [gallery] = await pool.query('SELECT * FROM gallery ORDER BY id DESC LIMIT 8');
  return { categories, contact: contactRows[0] || {}, gallery };
};

router.get('/', async (req, res, next) => {
  try {
    const [featured] = await pool.query('SELECT * FROM menu_items WHERE is_available=1 ORDER BY id DESC LIMIT 4');
    res.render('index', { ...(await siteData()), featured });
  } catch (e) { next(e); }
});
router.get('/menu', async (req, res, next) => {
  try {
    const [menu] = await pool.query('SELECT mi.*, c.name as category_name FROM menu_items mi JOIN categories c ON c.id=mi.category_id ORDER BY c.name, mi.name');
    res.render('menu', { ...(await siteData()), menu });
  } catch (e) { next(e); }
});
router.get('/catering', async (req, res, next) => { try { res.render('catering', await siteData()); } catch(e){next(e);} });
router.post('/catering', [body('name').trim().notEmpty(), body('phone').trim().notEmpty()], async (req,res,next)=>{
  const errors=validationResult(req); if(!errors.isEmpty()) return res.status(400).send('Invalid input');
  try{ await pool.query('INSERT INTO inquiries(name,phone,message,type) VALUES(?,?,?,?)',[req.body.name,req.body.phone,req.body.message,'catering']);res.redirect('/catering?success=1');}catch(e){next(e);} });
router.get('/gallery', async (req,res,next)=>{ try{const [images]=await pool.query('SELECT * FROM gallery ORDER BY id DESC');res.render('gallery',{...(await siteData()),images});}catch(e){next(e);} });
router.get('/contact', async (req,res,next)=>{ try{res.render('contact', await siteData());}catch(e){next(e);} });
router.post('/contact', [body('name').trim().notEmpty(), body('phone').trim().notEmpty()], async (req,res,next)=>{
  const errors=validationResult(req); if(!errors.isEmpty()) return res.status(400).send('Invalid input');
  try{ await pool.query('INSERT INTO inquiries(name,phone,message,type) VALUES(?,?,?,?)',[req.body.name,req.body.phone,req.body.message,'contact']);res.redirect('/contact?success=1');}catch(e){next(e);} });

module.exports = router;
