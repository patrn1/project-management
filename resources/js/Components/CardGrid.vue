<style scoped>
    .v-card {
        height: 200px;
        max-width: 400px;
    }
    :deep(.v-card-text), :deep(.v-card-subtitle) {
        white-space: pre;
        overflow: hidden;
    }
</style>
<script setup>

defineProps({
  itemList: {
    type: Array,
  },
  cardTitleGetter: {
    type: Function,
  },
  cardTextGetter: {
    type: Function,
  },
  cardSubtitleGetter: {
    type: Function,
  },
  onCardClick: {
    type: Function,
  },
  buttonsGetter: {
    type: Function,
  },
});

</script>

<template>
    <div class="card-list grid sm:grid-cols-1 md:grid-cols-3 gap-2 bg-white shadow sm:rounded-lg">

        <template v-for="(item, i) in itemList" :key="i">
            <div class="card-wrapper">
                <v-card
                    class="d-flex flex-column"
                    variant="outlined"
                    :title="cardTitleGetter(item)"
                    :text="cardTextGetter(item)"
                    :subtitle="cardSubtitleGetter(item)"
                    @click="onCardClick(item)"
                >
                    <v-spacer></v-spacer>

                    <v-card-actions>

                        <slot :item="item"></slot>

                    </v-card-actions>
                    <div></div>
                </v-card>
            </div>
        </template>
    </div>
</template>
