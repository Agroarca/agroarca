<script>
import { ref } from 'vue'
import VueDatepicker from '@vuepic/vue-datepicker'

export default{
    props: ['placeholder', 'name', 'minDate', 'maxDate'],
    components: {
        VueDatepicker
    },
    setup(props) {
        const date = ref(new Date());

        let config = {
            format: 'dd/MM/yyyy',
            locale: "pt-BR",
            monthNameFormat: "long",
            selectText: "Selecionar",
            cancelText: "Cancelar",
            autoApply : true,
            closeOnAutoApply: true,
            name: props.name,
            enableTimePicker: false,
            placeholder: props.placeholder ?? "Selecione uma data",
            weekStart: 0
        }

        if(props.minDate){
            config.minDate = props.minDate
            config.preventMinMaxNavigation = true
        }

        if(props.maxDate){
            config.maxDate = props.maxDate
            config.preventMinMaxNavigation = true
        }

        return {
            date,
            config,
            days: ['dom', 'seg', 'ter', 'qua', 'qui', 'sex', 'sáb'],
        }
    }
}
</script>

<template>
    <VueDatepicker v-model="date" v-bind="config">
        <template #calendar-header="{index}">
            <span>{{ days[index] }}</span>
        </template>
    </VueDatepicker>
</template>
