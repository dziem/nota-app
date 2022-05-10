<template>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <div class="form-group">
                <strong>Nama Supplier:</strong>
                <input type="text" name="name" class="form-control" placeholder="Nama Supplier" v-model="name">
            </div>
            <div class="form-group mt-3">
                <button class="btn btn-success" @click.prevent="addNewItem">
                    Tambah Item
                </button>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, index) in items" class="align-middle">
                        <td>
                            {{ index + 1 }}
                        </td>
                        <td>
                            <select class="form-select" aria-label="Nama Barang" :name="`item[${index}][item_id]`" v-model="row.id" @change="setBrand(row.id, index)">
                                <option v-for="(price, i) in prices" :value="price.id">{{ price.name }}</option>
                            </select>
                            <input type="hidden" :name="`item[${index}][name]`" class="form-control" v-model="row.name">
                        </td>
                        <td>
                            <input type="number" min="0" :name="`item[${index}][qty]`" class="form-control" v-model="row.quantity">
                        </td>
                        <td>
                            <button class="btn btn-warning" @click.prevent="removeItem(index)">
                                Hapus
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <button class="btn btn-success" :disabled='isDisabled' @click.prevent="submit()">
                Submit
            </button>
            <button ref="submit" style="display:none;">Submit</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "InvoiceFormComponent",

    props: [
        'prices',
    ],

    data() {
        return {
            items: [],
            item: {
                id: 0,
                name: '',
                quantity: 0
            },
            name: '',
            isDisabled: false
        }
    },

    methods: {
        addNewItem() {
            this.items.push(Vue.util.extend({}, this.item))
        },
        removeItem(index) {
            Vue.delete(this.items, index)
        },
        setBrand(id, index) {
            var price = this.prices.find(x => x.id === id)
            this.items[index].name = price.name
        },
        submit() {
            this.isDisabled = true
            this.$refs.submit.click()
        }
    },

    mounted() {
        this.addNewItem()
    }
}
</script>
