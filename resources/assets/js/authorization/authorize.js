import policies from './policies';

// Định nghĩa 1 hàm có thể xài như: authorize('modify', answer);
export default {
    install(Vue, options) {
        Vue.prototype.authorize = function(policy, model) {
            if ( ! window.Auth.signedIn) return false; // Phải login mới đi tiếp

            if (typeof policy === 'string' && typeof model === 'object') {
                const currentUser = window.Auth.user;

                return policies[policy](currentUser, model);
            }
        };

        Vue.prototype.signedIn = window.Auth.signedIn;
    }
}