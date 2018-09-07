<template>
    <div>
        <div class="form-group">
            <label for="birthday">Дата рождения</label>
            <datepicker id="birthday"
                        name="birthday"
                        :value="date.start"
                        :language="date.lang"
                        input-class="form-control"/>
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
                    lang: ru
                }
            }
        }
    }
</script>
