const eyeIcon = document.querySelector('.eye-icon');
const passwordInput = document.querySelector('input[type="password"]');

eyeIcon.addEventListener('click', () => {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.textContent = '🙈'; // Cambiar el icono si es necesario
    } else {
        passwordInput.type = 'password';
        eyeIcon.textContent = '👁️';
    }
});
