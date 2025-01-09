import './bootstrap';
import 'flowbite'
import axios from 'axios'
import { DataTable } from 'simple-datatables';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if (document.getElementById("search-table") && typeof DataTable !== 'undefined') {
    const dataTable = new DataTable("#search-table", {
        searchable: true,
        sortable: false
    });
}