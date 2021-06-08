<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Contacts
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <jet-validation-errors class="mb-4" />

        <form method="POST" @submit.prevent="submit">
          <div class="mb-4">
              <jet-label for="name" value="Name" />
              <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
          </div>
          <div class="mb-4">
              <jet-label for="email" value="Email" />
              <jet-input id="email" type="text" class="mt-1 block w-full" v-model="form.email" required />
          </div>
          <div class="mb-4">
              <jet-label for="role" value="Role" />
              <select id="role" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" v-model="form.role">
                <option value="0">Select Role</option>
                <option v-for="(role, id) in roles" :key="id" :value="id">{{ role }}</option>
              </select>
          </div>

          <div class="py-4">
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Update
            </jet-button>
            <jet-secondary-button @click="cancel" class="ml-2">
              Cancel
            </jet-secondary-button>
          </div>
        </form>        
      </div>
    </div>
  </app-layout>
</template>

<script>
  import { useForm } from '@inertiajs/inertia-vue3'
  import AppLayout from '@/Layouts/AppLayout'
  import JetFormSection from '@/Jetstream/FormSection'
  import JetButton from '@/Jetstream/Button'
  import JetSecondaryButton from '@/Jetstream/SecondaryButton'
  import JetLabel from '@/Jetstream/Label'
  import JetInput from '@/Jetstream/Input'
  import JetInputError from '@/Jetstream/InputError'
  import JetActionMessage from '@/Jetstream/ActionMessage'

  export default {
    components: {
      AppLayout,
      JetFormSection,
      JetLabel,
      JetInput,
      JetInputError,
      JetButton,
      JetSecondaryButton,
      JetActionMessage,
    },
    props: {
      contact: {
        type: Object,
        default: {}
      },
      roles: {
        type: Object,
        default: {}
      }
    },
    data() {
      return {
        form: useForm({
          _method: "PUT",
          name: this.contact.name,
          email: this.contact.email,
          role: this.contact.role_id,
        }),
      }
    },
    
    methods: {
        submit() {
            this.form.post(this.route('contacts.update', this.contact.id), {

                // onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        },
        cancel() {
          history.back()
        }
    }
  }
</script>
