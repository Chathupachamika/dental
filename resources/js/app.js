import './bootstrap';
import Alpine from 'alpinejs';
import axios from 'axios';
import jQuery from 'jquery';
import Swal from 'sweetalert2';

window.$ = window.jQuery = jQuery;
window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();
