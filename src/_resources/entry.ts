import './entry.scss';
import jQuery from "jquery";

// Make jQuery globally available
window['jQuery'] = window['$'] = jQuery;

class Entry {
    constructor() {

        console.log('Hello World');
    }
}

new Entry();