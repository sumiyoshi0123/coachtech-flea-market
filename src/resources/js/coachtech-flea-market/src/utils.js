export function nl2br(str) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    return str.replace(/\n/g, '<br>');
}