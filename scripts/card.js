const card = document.getElementById("search-overlay");
                
document.addEventListener("mousemove", (e) => {
    const { clientX, clientY } = e;
    const { innerWidth, innerHeight } = window;
    const xRotation = ((clientY / innerHeight) - 0.5) * 30;
    const yRotation = ((clientX / innerWidth) - 0.5) * -30;
    
    card.style.transform = `perspective(1000px) rotateX(${xRotation}deg) rotateY(${yRotation}deg)`;
});