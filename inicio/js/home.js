document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in').forEach(section => {
        observer.observe(section);
    });

    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
        e.preventDefault(); 
        alert('Agendamento realizado com sucesso!');
        form.reset(); 
    });
