export default function useHelper() {
    function getProfile(profile) {
        return profile ? `${import.meta.env.VITE_API_BASE_URL}/uploads/${profile}` : '/fallback-avatar.jpg';
    }

    return { getProfile };
}
