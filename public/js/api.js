function getCookie(name) {
    const cookies = document.cookie.split('; ');
    for (const cookie of cookies) {
        const eq = cookie.indexOf('=');
        if (eq === -1) continue;
        const key = cookie.slice(0, eq);
        if (key === name) return decodeURIComponent(cookie.slice(eq + 1));
    }
    return null;
}

async function apiFetch(url, options = {}) {
    const opts = { ...options };
    opts.headers = { ...(opts.headers || {}) };

    const method = (opts.method || 'GET').toUpperCase();
    if (method !== 'GET' && method !== 'HEAD') {
        const csrf = getCookie('csrf_token');
        if (csrf) {
            opts.headers['X-CSRF-Token'] = csrf;
        }
    }

    if (opts.body && !opts.headers['Content-Type'] && typeof opts.body === 'string') {
        opts.headers['Content-Type'] = 'application/json';
    }

    return fetch(url, opts);
}
