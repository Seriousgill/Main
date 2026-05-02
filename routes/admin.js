const express = require('express');
const bcrypt = require('bcryptjs');
const multer = require('multer');
const path = require('path');
const { body, validationResult } = require('express-validator');
const pool = require('../config/db');
const auth = require('../middleware/auth');

const router = express.Router();
const storage = multer.diskStorage({
  destination: (_, __, cb) => cb(null, path.join(__dirname, '../public/uploads')),
  filename: (_, file, cb) => cb(null, `${Date.now()}-${file.originalname.replace(/\s+/g, '-')}`)
});
const upload = multer({ storage, fileFilter: (_, file, cb) => cb(null, /image\/(jpeg|png|webp)/.test(file.mimetype)) });

router.get('/login', (_,res)=>res.render('admin/login',{error:null}));
router.post('/login', async (req,res,next)=>{
  try{
    const [rows]=await pool.query('SELECT * FROM users WHERE username=? LIMIT 1',[req.body.username]);
    const user=rows[0];
    if(!user || !(await bcrypt.compare(req.body.password,user.password))) return res.render('admin/login',{error:'Invalid credentials'});
    req.session.admin={id:user.id,username:user.username}; res.redirect('/admin');
  }catch(e){next(e)}
});
router.post('/logout',auth,(req,res)=>req.session.destroy(()=>res.redirect('/admin/login')));
router.get('/',auth, async (req,res,next)=>{
  try{
    const [[{count:menuCount}],[{count:inqCount}]] = await Promise.all([
      pool.query('SELECT COUNT(*) as count FROM menu_items'),
      pool.query('SELECT COUNT(*) as count FROM inquiries')
    ]);
    res.render('admin/dashboard',{menuCount,inqCount,admin:req.session.admin});
  }catch(e){next(e)}
});
router.get('/categories',auth,async(req,res,next)=>{try{const [categories]=await pool.query('SELECT * FROM categories');res.render('admin/categories',{categories});}catch(e){next(e)}});
router.post('/categories',auth,[body('name').trim().notEmpty()],async(req,res,next)=>{if(!validationResult(req).isEmpty()) return res.redirect('/admin/categories');try{await pool.query('INSERT INTO categories(name) VALUES(?)',[req.body.name]);res.redirect('/admin/categories');}catch(e){next(e)}});
router.post('/categories/:id/delete',auth,async(req,res,next)=>{try{await pool.query('DELETE FROM categories WHERE id=?',[req.params.id]);res.redirect('/admin/categories');}catch(e){next(e)}});
router.get('/menu',auth,async(req,res,next)=>{try{const [items]=await pool.query('SELECT mi.*, c.name as category_name FROM menu_items mi LEFT JOIN categories c ON mi.category_id=c.id'); const [categories]=await pool.query('SELECT * FROM categories');res.render('admin/menu',{items,categories});}catch(e){next(e)}});
router.post('/menu',auth,upload.single('image'),async(req,res,next)=>{try{await pool.query('INSERT INTO menu_items(name,description,price,image,category_id,is_available,is_veg) VALUES(?,?,?,?,?,?,?)',[req.body.name,req.body.description,req.body.price,req.file?`/uploads/${req.file.filename}`:null,req.body.category_id,req.body.is_available?1:0,req.body.is_veg?1:0]);res.redirect('/admin/menu');}catch(e){next(e)}});
router.post('/menu/:id/delete',auth,async(req,res,next)=>{try{await pool.query('DELETE FROM menu_items WHERE id=?',[req.params.id]);res.redirect('/admin/menu');}catch(e){next(e)}});
router.get('/gallery',auth,async(req,res,next)=>{try{const [images]=await pool.query('SELECT * FROM gallery');res.render('admin/gallery',{images});}catch(e){next(e)}});
router.post('/gallery',auth,upload.single('image'),async(req,res,next)=>{try{if(req.file){await pool.query('INSERT INTO gallery(image,category) VALUES(?,?)',[`/uploads/${req.file.filename}`,req.body.category]);}res.redirect('/admin/gallery');}catch(e){next(e)}});
router.post('/gallery/:id/delete',auth,async(req,res,next)=>{try{await pool.query('DELETE FROM gallery WHERE id=?',[req.params.id]);res.redirect('/admin/gallery');}catch(e){next(e)}});
router.get('/settings',auth,async(req,res,next)=>{try{const [rows]=await pool.query('SELECT * FROM contact_info LIMIT 1');res.render('admin/settings',{contact:rows[0]||{}});}catch(e){next(e)}});
router.post('/settings',auth,async(req,res,next)=>{try{await pool.query('DELETE FROM contact_info');await pool.query('INSERT INTO contact_info(phone,address,email,hours) VALUES(?,?,?,?)',[req.body.phone,req.body.address,req.body.email,req.body.hours]);res.redirect('/admin/settings');}catch(e){next(e)}});
router.get('/inquiries',auth,async(req,res,next)=>{try{const [rows]=await pool.query('SELECT * FROM inquiries ORDER BY id DESC');res.render('admin/inquiries',{rows});}catch(e){next(e)}});

module.exports = router;
