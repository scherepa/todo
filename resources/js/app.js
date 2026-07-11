import $ from 'jquery';
window.$ = window.jQuery = $;
// set jquery and bootstrap
// on previous old versions used just cdn
// here installed via: npm install jquery bootstrap @popperjs/core
import 'bootstrap';
import '../css/app.css';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept': 'application/json'
    }
});
