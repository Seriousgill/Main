const search=document.getElementById('menuSearch');
const filters=document.querySelectorAll('#filters button');
const items=document.querySelectorAll('.menu-item');
if(search){search.addEventListener('input',()=>{const v=search.value.toLowerCase();items.forEach(i=>i.style.display=i.dataset.name.includes(v)?'':'none');});}
filters.forEach(b=>b.addEventListener('click',()=>{const f=b.dataset.filter;items.forEach(i=>i.style.display=(f==='all'||i.dataset.category===f)?'':'none');}));
document.querySelectorAll('.lightbox').forEach(img=>img.addEventListener('click',()=>window.open(img.src,'_blank')));
