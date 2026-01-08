import axios from 'axios';
import { APP_CONFIG } from '../config/constants';

const http = axios.create({
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json',
    },
    timeout: APP_CONFIG.apiTimeout
});

// Response Interceptor (Middleware Frontend)
http.interceptors.response.use(
    response => response,
    error => {
        if (error.response) {
            // Jika sesi habis (401) atau dilarang (403)
            if (error.response.status === 401 || error.response.status === 419) {
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
                window.location.href = '/login';
            }
        } else {
            // Error koneksi / Network
            alert(APP_CONFIG.messages.networkError);
        }
        return Promise.reject(error);
    }
);

export default http;