<script>
import { ref } from 'vue'
import VueDatepicker from '@vuepic/vue-datepicker'

export default{
    props: ['placeholder', 'name', 'minDate', 'maxDate', 'data', 'disabled'],
    components: {
        VueDatepicker
    },
    setup(props) {
        const date = ref(props.data);

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
            weekStart: 0,
            disabled: props.disabled ?? false,
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
    },
    methods: {
        alterarData(){
            this.$emit('alterarData', this.date)
        }
    }
}
</script>

<template>
    <VueDatepicker v-model="date" v-bind="config" @update:modelValue="alterarData()">
        <template #calendar-header="{index}">
            <span>{{ days[index] }}</span>
        </template>
    </VueDatepicker>
</template>
