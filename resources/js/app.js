import './bootstrap';


import jQuery from 'jquery';
window.$ = jQuery;

import JSZip from 'jszip';
window.JSZip = JSZip;

// USATA CDN IN APP_LAYOUT PER PROBLEMI COL FONT
// import pdfMake from 'pdfmake';
// window.pdfMake = pdfmake;

import DataTable from 'datatables.net-bs5';
import 'datatables.net-autofill-bs5';
import 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.colVis.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';
import 'datatables.net-colreorder-bs5';
import 'datatables.net-fixedcolumns-bs5';
import 'datatables.net-fixedheader-bs5';
import 'datatables.net-keytable-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-rowgroup-bs5';
import 'datatables.net-rowreorder-bs5';
import 'datatables.net-scroller-bs5';
import 'datatables.net-searchbuilder-bs5';
import 'datatables.net-searchpanes-bs5';
import 'datatables.net-select-bs5';
import 'datatables.net-staterestore-bs5';
import 'datatables.net-buttons/js/buttons.html5.mjs';
window.Datable = DataTable;



import DateTime from 'datatables.net-datetime';
window.DateTime = DateTime;


// Complete SortableJS (with all plugins)
import Sortable from 'sortablejs/modular/sortable.complete.esm.js';


// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle';

// import styles bundle
import 'swiper/css/bundle';

window.Sortable = Sortable;
window.Swiper = Swiper;

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js', { scope: '/' }).then(function (registration) {
        // console.log(`SW registered successfully!`);
    }).catch(function (registrationError) {
        // console.log(`SW registration failed`);
    });
}


