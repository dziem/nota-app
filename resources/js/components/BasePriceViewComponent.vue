<template>
    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
        <strong>Harga Beli (Kulakan):</strong>
        <div v-for="(row, index) in items" class="form-group mt-1">
            <strong>Harga Beli {{ index + 1}}:</strong>
            <p>{{ rupiah(row.base_price) }} ({{ formatDate(row.updated_at) }})</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "BasePriceViewComponent",

    props: [
        'prices',
    ],

    data() {
        return {
            items: [],
            item: {
                id: 0,
                base_price: 0
            }
        }
    },

    methods: {
        formatDate(date) {
            var myDate = new Date(date)
            var options = {year: 'numeric', month: 'short', day: 'numeric'};
            return myDate.toLocaleDateString("en-GB", options)
        },
        rupiah(amount) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
                }).format(amount);
        }
    },

    mounted() {
        if (this.prices != null) {
            this.items = this.prices
        }
    }
}
</script>
