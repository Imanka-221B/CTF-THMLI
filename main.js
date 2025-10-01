document.addEventListener('DOMContentLoaded', () => {
  // Decorative accent bubbles like the original theme
  const colors = ['#F37335','#FDC830','#155799'];
  const bubble = () => {
    const b = document.createElement('div');
    b.className = 'bubble';
    b.style.position = 'fixed';
    b.style.borderRadius = '50%';
    b.style.opacity = '0.15';
    const s = 20 + Math.random()*80;
    b.style.width = b.style.height = s + 'px';
    b.style.background = colors[Math.floor(Math.random()*colors.length)];
    b.style.right = Math.random()*90 + 'vw';
    b.style.top = Math.random()*60 + 'vh';
    document.body.appendChild(b);
    setTimeout(()=>b.remove(), 6000);
  };
  for (let i=0;i<6;i++) setTimeout(bubble, i*400);
});
