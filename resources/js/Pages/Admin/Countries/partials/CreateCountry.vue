<script setup>
import {ref, reactive} from "vue";
import {useAPI} from "@/Composables/useAPI";
import {useNotificationStore} from "@/stores/notification";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/Custom/SelectInput.vue";
import Spinner from "@/Components/Custom/Spinner.vue";

const api = useAPI();
const notification = useNotificationStore();

// Emits
const emit = defineEmits(['countryAdded'])

// Props:
const props = defineProps({
    currencies: {
        type: Array,
        required: true
    }
})

// Form:
const formOpened = ref(false);

const openForm = () => {
    formOpened.value = true;
}

const endAdd = () => {
    formOpened.value = false;
    api.errors.value = {};
    resetCountry();
}

const country = reactive({
    'label': '',
    'code': '',
    'code_iso_2': '',
    'can_send': '',
    'can_receive': '',
    'currency_id': null,
})

const sendOptions = [
    {
        label: 'Yes',
        value: 'Y'
    },
    {
        label: 'No',
        value: 'N'
    }
];

const resetCountry = () => {
    country.label = ''
    country.country_id = null
}

const addCountry = async () => {
    api.startRequest();

    try {
        const res = await axios.post('/admin/countries/store', country)

        if (res.data.id || res.data.status === 'success') {
            notification.notify('Country added', 'success');
            endAdd();
            emit('countryAdded');
        }
    } catch (errors) {
        notification.notify('Error', 'error');
        api.handleErrors(errors)
    } finally {
        api.requestCompleted();
    }
}

</script>

<template>
    <div >
        <button @click="openForm" type="button" class="mb-8 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Add new country
        </button>


        <form v-show="formOpened" class="border-gray-400 border rounded-lg p-6 mb-8">
            <div class="flex flex-wrap gap-6 mb-10">
                <TextInput
                    v-model="country.label"
                    :errors="api.errors.value?.label"
                    label="Country Name"
                    placeholder="United States of America"
                    required
                    title="label"
                />

                <TextInput
                    v-model="country.code"
                    :errors="api.errors.value?.code"
                    label="Code ISO 3"
                    placeholder="USA"
                    required
                    title="code"
                />

                <TextInput
                    v-model="country.code_iso_2"
                    :errors="api.errors.value?.code_iso_2"
                    label="Code ISO 2"
                    placeholder="US"
                    required
                    title="code_iso_2"
                />

                <SelectInput
                    v-model="country.can_send"
                    :errors="api.errors.value?.can_send"
                    :options="sendOptions"
                    label="Can send"
                    required
                    placeholder=" Select "
                    title="can_send"
                    type="text"
                />

                <SelectInput
                    v-model="country.can_receive"
                    :errors="api.errors.value?.can_receive"
                    :options="sendOptions"
                    label="Can receive"
                    required
                    placeholder=" Select "
                    title="can_receive"
                    type="text"
                />

                <SelectInput
                    v-model="country.currency_id"
                    :errors="api.errors.value?.currency_id"
                    :options="currencies"
                    label="Currency"
                    required
                    placeholder=" Select "
                    title="currency_id"
                    type="text"
                    value-accessor="id"
                    label-accessor="name"
                />
            </div>

            <div class="flex gap-4 items-center">
                <button
                    @click="addCountry"
                    type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Add
                </button>
                <button
                    type="button"
                    @click="endAdd"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Cancel
                </button>

                <Spinner v-if="api.isLoading.value" class="button-spinner-center action-btn"/>
            </div>

        </form>

    </div>
</template>

<script>
export default {
    name: "CreateCountry"
}
</script>
