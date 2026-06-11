import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import '../../vendor/sampaui/sampaui/dist/sampaui.js';

window.Alpine = Alpine;

Alpine.data('docSearch', (items = []) => ({
    query: '',
    open: false,
    activeIndex: 0,
    items,
    normalize(value) {
        return String(value ?? '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase();
    },
    get results() {
        const term = this.normalize(this.query);

        if (! term) {
            return [];
        }

        return this.items
            .filter((item) => this.normalize(item.search).includes(term))
            .slice(0, 12);
    },
    get hasResults() {
        return this.results.length > 0;
    },
    select(index = this.activeIndex) {
        const item = this.results[index];

        if (item?.url) {
            window.location.href = item.url;
        }
    },
    next() {
        if (! this.hasResults) {
            return;
        }

        this.activeIndex = (this.activeIndex + 1) % this.results.length;
    },
    previous() {
        if (! this.hasResults) {
            return;
        }

        this.activeIndex = this.activeIndex === 0 ? this.results.length - 1 : this.activeIndex - 1;
    },
}));

Livewire.start();
