const API_BASE_URL =
    import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

export const api = {
    baseUrl: API_BASE_URL,

    getToken() {
        return localStorage.getItem('auth_token');
    },

    saveSession({ token, usuario, rol }) {
        localStorage.setItem('auth_token', token);
        localStorage.setItem('auth_user', JSON.stringify(usuario));
        localStorage.setItem('auth_rol', rol);
    },

    clearSession() {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('auth_user');
        localStorage.removeItem('auth_rol');
    },

    async request(endpoint, options = {}) {
        const url = `${API_BASE_URL}${endpoint.startsWith('/') ? endpoint : '/' + endpoint}`;
        const token = this.getToken();

        const headers = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            ...(token ? { 'Authorization': `Bearer ${token}` } : {}),
            ...(options.headers || {}),
        };

        const response = await fetch(url, {
            ...options,
            headers,
        });

        let data = {};
        try {
            data = await response.json();
        } catch (e) {
            data = {};
        }

        return {
            ok: response.ok,
            status: response.status,
            data,
        };
    },

    get(endpoint) {
        return this.request(endpoint, { method: 'GET' });
    },

    post(endpoint, body = {}) {
        return this.request(endpoint, {
            method: 'POST',
            body: JSON.stringify(body),
        });
    },

    put(endpoint, body = {}) {
        return this.request(endpoint, {
            method: 'PUT',
            body: JSON.stringify(body),
        });
    },

    delete(endpoint) {
        return this.request(endpoint, { method: 'DELETE' });
    }
};

// Exponer globalmente para poder usarlo en cualquier vista Blade
window.api = api;