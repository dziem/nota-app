<template>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <div class="form-group">
                <strong>Nama Pembeli:</strong>
                <input type="text" name="name" class="form-control" placeholder="Nama Pembeli" v-model="name">
            </div>
            <div class="form-check mt-1">
                <input class="form-check-input" name="reseller" value="true" type="checkbox" id="check" v-model="notReseller" @change="setSpecialPrice()">
                <label class="form-check-label" for="check">
                    Bukan Reseller
                </label>
            </div>
            <div class="form-group mt-3">
                <button class="btn btn-success" @click.prevent="addNewItem">
                    Tambah Item
                </button>
            </div>
            <div class="form-check mt-1">
                <input class="form-check-input" name="dp" value="true" type="checkbox" id="dp" v-model="withDp">
                <label class="form-check-label" for="dp">
                    Ada DP / Diskon
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
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
                            <input type="hidden" :name="`item[${index}][base_price]`" class="form-control" v-model="row.base_price">
                        </td>
                        <td>
                            <input type="number" min="0" :name="`item[${index}][qty]`" class="form-control" v-model="row.quantity" @keyup="setTotalPrice(row.id, index)">
                        </td>
                        <td>
                            <input type="hidden" :name="`item[${index}][price]`" v-model="row.price">
                            Rp. {{ (row.quantity * row.price).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') }}
                        </td>
                        <td>
                            <button class="btn btn-warning" @click.prevent="removeItem(index)">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Total Harga</td>
                        <td>Rp. {{ (totalPrice).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') }}</td>
                        <td></td>
                    </tr>
                    <template v-if="withDp">
                        <tr>
                            <td></td>
                            <td></td>
                            <td>DP / Diskon</td>
                            <td>
                                <input type="number" min="0" :max="totalPrice" :name="`dp`" class="form-control" v-model="dp">
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Total Bayar</td>
                            <td>Rp. {{ (totalPrice - dp).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') }}</td>
                            <td></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <button class="btn btn-primary" :disabled='isDisabled' @click.prevent="submit('save')">
                Simpan
            </button>
            <button class="btn btn-success" :disabled='isDisabled' @click.prevent="submit('print')">
                Print
            </button>
            <button ref="save" name="send" value="save" style="display:none;">Submit</button>
            <button ref="print" name="send" value="print" style="display:none;">Submit</button>
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
                quantity: 0,
                price: 0,
                base_price: 0
            },
            name: '',
            notReseller: false,
            isDisabled: false,
            withDp: false,
            dp: 0
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
            this.items[index].base_price = price.base_price
            if (this.notReseller) {
                this.items[index].price = price.special_price
            } else {
                if (this.items[index].quantity >= 10 && this.items[index].quantity < 20) {
                    this.items[index].price = price.bulk_price
                } else if (this.items[index].quantity >= 20) {
                    this.items[index].price = price.bulk_price_too
                } else {
                    this.items[index].price = price.normal_price
                }
            }
        },
        setTotalPrice(id, index) {
            var price = this.prices.find(x => x.id === id)
            if (this.notReseller) {
                this.items[index].price = price.special_price
            } else {
                if (this.items[index].quantity >= 10 && this.items[index].quantity < 20) {
                    this.items[index].price = price.bulk_price
                } else if (this.items[index].quantity >= 20) {
                    this.items[index].price = price.bulk_price_too
                } else {
                    this.items[index].price = price.normal_price
                }
            }
        },
        setSpecialPrice() {
            this.items.forEach(row => {
                var price = this.prices.find(x => x.id === row.id)
                if (this.notReseller) {
                    row.price = price.special_price
                } else {
                    if (row.quantity >= 10 && row.quantity < 20) {
                        row.price = price.bulk_price
                    } else if (row.quantity >= 20) {
                        row.price = price.bulk_price_too
                    } else {
                        row.price = price.normal_price
                    }
                }
            })
        },
        submit(value) {
            this.isDisabled = true
            if (value == 'save') {
                this.$refs.save.click()
            } else if (value == 'print') {
                this.$refs.print.click()
            }
        }
    },

    computed: {
        'totalPrice': function() {
            let total = 0
            this.items.forEach(row => {
                total += row.quantity * row.price
            })
            return total
        }
    },

    mounted() {
        this.addNewItem()
    }
}
</script>
