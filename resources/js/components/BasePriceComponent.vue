<template>
    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
        <strong>Harga Beli (Kulakan):</strong>
        <div class="form-group">
            <button class="btn btn-success" @click.prevent="addNewItem">
                Tambah Harga Beli
            </button>
        </div>
        <div v-for="(row, index) in items" class="form-group mt-1">
            <strong>Harga Beli {{ index + 1}}:</strong>
            <div class="row">
                <div class="col-10">
                    <input type="number" min="0" :name="`item[${index}][price]`" class="form-control" :placeholder="`Harga Beli ${index + 1}`" v-model="row.base_price">
                    <input type="hidden" :name="`item[${index}][id]`" v-model="row.id">
                </div>
                <div class="col-2">
                    <button class="btn btn-warning" @click.prevent="removeItem(index)">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BasePriceComponent",

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
        addNewItem() {
            this.items.push(Vue.util.extend({}, this.item))
        },
        removeItem(index) {
            Vue.delete(this.items, index)
        }
    },

    mounted() {
        if (this.prices != null) {
            this.items = this.prices
        } else {
            this.addNewItem()
        }
    }
}
</script>
