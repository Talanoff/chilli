<template>
    <div>
        <div class="form-group">
            <label for="birthday">Дата рождения</label>
            <datepicker id="birthday"
                        :value="date.start"
                        :language="date.lang"
                        input-class="form-control"
                        @input="formatDate"/>
            <input type="hidden" name="birthday" :value="date.formatted">
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import {ru} from 'vuejs-datepicker/dist/locale'
    import moment from 'moment';

    export default {
        components: {
            Datepicker
        },
        data() {
            return {
                date: {
                    start: moment().subtract(18, 'years').format(),
                    formatted: '',
                    lang: ru
                }
            }
        },
        methods: {
            formatDate(date) {
                this.date.formatted = moment(date).format('YYYY-MM-DD')
            }
        }
    }
</script>
