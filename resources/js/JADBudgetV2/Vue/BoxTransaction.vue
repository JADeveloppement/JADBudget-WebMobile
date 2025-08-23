<template>
    <div class="box">
        <div class="title">
            {{ title }}
        </div>
        <div class="content">
            <div v-if="items && items.length > 0">
                <ul>
                    <li class="transactionItem" v-for="(item, index) in items" :key="index" :data-id="item[0]">
                        <div class="label">
                            {{ item[1] }}
                        </div>
                        <div class="amount">
                            {{ item[2] }} €
                        </div>
                    </li>
                </ul>
            </div>
            <div v-else class="item-list">
                <ul>
                    <li>Aucun élément.</li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },
        items: {
            type: Array,
            default: () => []
        }
    }
}
</script>