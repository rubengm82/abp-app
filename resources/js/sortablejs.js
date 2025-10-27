import Sortable from 'sortablejs';

const assigned = document.getElementById('assigned');
const unassigned = document.getElementById('unassigned');

if (assigned && unassigned) {
    new Sortable(assigned, {
        group: 'shared',
        animation: 150
    });

    new Sortable(unassigned, {
        group: 'shared',
        animation: 150
    });
}
