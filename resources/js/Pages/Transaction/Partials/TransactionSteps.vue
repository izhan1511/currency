<script setup>

import {computed} from "vue";

const props = defineProps({
    currentStep: {
        type: String,
        default: 'sender-info'
    }
})

const steps = {
    'sender-info': 1,
    'transaction-info': 2,
    'receiver-info': 3,
    'card-info': 4,
};

const completedSteps = computed( () => {
    return steps[props.currentStep];
});

</script>

<template>
    <div class="transaction-timeline-steps">
        <ol class="flex items-center w-full">
            <li :class="{'current': currentStep === 'sender-info', 'completed': completedSteps > 1}">
                <span class="step-icon"></span>
                <div class="step-text first">
                    {{ currentStep.replace('-', ' ')}}
                </div>
            </li>
            <li :class="{'current': currentStep === 'transaction-info', 'completed': completedSteps > 2}">
                <span class="step-icon"></span>
                <div class="step-text">
                    {{ currentStep.replace('-', ' ')}}
                </div>
            </li>
            <li :class="{'current': currentStep === 'receiver-info', 'completed': completedSteps > 3}">
                <span class="step-icon"></span>
                <div class="step-text">
                    {{ currentStep.replace('-', ' ')}}
                </div>
            </li>
            <li :class="{'current': currentStep === 'card-info'}">
                <span class="step-icon"></span>
                <div class="step-text last">
                    {{ currentStep.replace('-', ' ')}}
                </div>
            </li>
        </ol>
    </div>
</template>

<script>
export default {
    name: "TransactionSteps"
}
</script>
