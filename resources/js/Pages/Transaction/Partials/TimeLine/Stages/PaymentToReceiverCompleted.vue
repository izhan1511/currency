<script setup>
import Modal from "@/Components/Custom/Modal.vue";
import {ref} from "vue";
import {useAPI} from "@/Composables/useAPI";
import {transactionStatuses} from "@/helpers/transactionStatuses";
import {useNotificationStore} from "@/stores/notification";
import FiftyText from "@/Components/Design/FiftyText.vue";
import NewActionButton from "@/Components/Design/NewActionButton.vue";
import SuccessIcon from "@/Components/Custom/SuccessIcon.vue";

const props = defineProps({
    transaction: {
        type: Object,
        required: true
    },
    isHidden: {
        type: Boolean,
        default: false
    }
})

const api = useAPI()
const notification = useNotificationStore()
const emit = defineEmits(['transactionUpdated'])

const isModalOpened = ref(false);

const closeModal = () => {
    isModalOpened.value = false;
}
const openModal = () => {
    if (props.isHidden) return;
    isModalOpened.value = true;
}

const confirmPaymentToReceiver = async () => {
    if (props.isHidden) return;

    api.startRequest();
    try {

        const res = await axios.post('/api/confirm-payment-to-receiver', {
            transactionId: props.transaction.id
        });

        console.log(res);

        if (res.data.status === 'success') {
            notification.notify('Payment to receiver confirmed', 'success');
            emit('transactionUpdated', res.data.transaction)
        }

    } catch (errors) {
        api.handleErrors(errors)
        notification.notify('Error confirming payment...', 'error');
    } finally {
        api.requestCompleted();
    }
}

</script>


<template>
    <li :class="{'opacity-30': isHidden}">
        <div class="track-step-icon w-3 h-3 mt-1.5 -left-1.5 border border-white"></div>

        <FiftyText class="mb-2">
            {{ transaction.payment_to_receiver_completed_at }}
        </FiftyText>

        <FiftyText variation="body-xl" color="dark">
            Payment Complete
        </FiftyText>

        <FiftyText>
            <slot/>
        </FiftyText>

        <div class="receiver-action-buttons">
            <Modal :close="closeModal" :isOpen="isModalOpened" header="Proof Of Payment">
                <template #button>
                    <NewActionButton
                        @click="openModal"
                        title="View Proof"
                    />
                </template>

                <template #content>

                    <div class="p-6">
                        <img :src="`${transaction.opposite_transaction?.payment_intent.payment_proof}`"
                             alt="proof of payment">
                    </div>

                </template>

            </Modal>

            <div class="confirmed-button" v-if="transactionStatuses[transaction.status] > 5">
                <SuccessIcon class="icon" />
                Payment Confirmed
            </div>

            <NewActionButton
                v-else
                :isLoading="api.isLoading.value"
                @click="confirmPaymentToReceiver"
                title="Confirm Payment Received"
                :reversed="true"
            />
        </div>
    </li>
</template>

<script>
export default {
    name: "PaymentToReceiverCompleted"
}
</script>
