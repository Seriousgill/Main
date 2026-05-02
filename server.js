require('dotenv').config();
const express = require('express');
const path = require('path');
const session = require('express-session');
const helmet = require('helmet');
const methodOverride = require('method-override');

const publicRoutes = require('./routes/public');
const adminRoutes = require('./routes/admin');

const app = express();
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

app.use(helmet({ contentSecurityPolicy: false }));
app.use(express.urlencoded({ extended: true }));
app.use(express.json());
app.use(methodOverride('_method'));
app.use(session({
  secret: process.env.SESSION_SECRET || 'fallback-secret',
  resave: false,
  saveUninitialized: false,
  cookie: { httpOnly: true, sameSite: 'lax' }
}));
app.use('/uploads', express.static(path.join(__dirname, 'public/uploads')));
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', publicRoutes);
app.use('/admin', adminRoutes);

app.use((err, req, res, next) => {
  console.error(err);
  res.status(500).send('Something went wrong.');
});

const port = process.env.PORT || 3000;
app.listen(port, () => console.log(`Server running on ${port}`));
