<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    status?: string;
}>();

const form = useForm({
    code: '',
});

const submit = () => {
    form.post(route('two-factor.login.store'), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Two-Factor Challenge" />

        <div class="mb-4 text-sm text-gray-600">
            <template v-if="status === 'success' || status === 'failed'">
                <div class="mb-4 font-medium text-sm text-green-600" v-if="status === 'success'">
                    You have successfully enabled two-factor authentication.
                </div>
                <div class="mb-4 font-medium text-sm text-red-600" v-else>
                    Please enter your two-factor authentication code to continue.
                </div>
            </template>
            <template v-else>
                Please confirm access to your account by entering the authentication code provided by your authenticator application.
            </template>
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="code" value="Code" />
                <TextInput
                    id="code"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.code"
                    required
                    autofocus
                    autocomplete="one-time-code"
                />
                <InputError class="mt-2" :message="form.errors.code" />
            </div>

            <div class="flex justify-end mt-4">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
