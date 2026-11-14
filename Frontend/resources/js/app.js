import { api } from './api';

document.addEventListener('DOMContentLoaded', () => {
    const token = api.getToken();
    const userStr = localStorage.getItem('auth_user');
    const rol = localStorage.getItem('auth_rol');

    const navGuest = document.getElementById('nav-guest');
    const navAuth = document.getElementById('nav-auth');

    if (token && userStr && navGuest && navAuth) {
        const user = JSON.parse(userStr);
        navGuest.classList.add('hidden');
        navAuth.classList.remove('hidden');
        navAuth.classList.add('flex');

        document.getElementById('nav-user-name').textContent = user.nombre_completo;
        document.getElementById('nav-user-role').textContent = rol;
    }

    const btnLogout = document.getElementById('btn-logout');
    if (btnLogout) {
        btnLogout.addEventListener('click', async() => {
            try {
                await api.post('/auth/logout');
            } catch (e) {
                console.error(e);
            } finally {
                api.clearSession();
                window.location.href = '/login';
            }
        });
    }
});