<template>
  <admin-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Permissions
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
              <jet-label for="slug" value="Slug" />
              <jet-input id="slug" type="text" class="mt-1 block w-full" v-model="form.slug" required />
          </div>

          <div class="py-4">
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Create
            </jet-button>
            <jet-secondary-button @click="cancel" class="ml-2">
              Cancel
            </jet-secondary-button>
          </div>
        </form>        
      </div>
    </div>
  </admin-layout>
</template>

<script>
  import { useForm } from '@inertiajs/inertia-vue3'
  import AdminLayout from '@/Layouts/AdminLayout'
  import JetFormSection from '@/Jetstream/FormSection'
  import JetButton from '@/Jetstream/Button'
  import JetSecondaryButton from '@/Jetstream/SecondaryButton'
  import JetLabel from '@/Jetstream/Label'
  import JetInput from '@/Jetstream/Input'
  import JetInputError from '@/Jetstream/InputError'
  import JetActionMessage from '@/Jetstream/ActionMessage'

  export default {
    components: {
      AdminLayout,
      JetFormSection,
      JetLabel,
      JetInput,
      JetInputError,
      JetButton,
      JetSecondaryButton,
      JetActionMessage,
    },
    props: {
      permission: {
        type: Object,
        default: {}
      }
    },
    data() {
      return {
        form: useForm({
          _method: this.permission.id ? "PUT" : "POST",
          name: this.permission.name,
          slug: this.permission.slug,
        }),
      }
    },
    computed: {
      computedRoute() {
        return this.permission.id ? this.route('permissions.update', this.permission.id) : this.route('permissions.store')
      }
    },
    watch: {
      'form.name': function(val) {
        this.form.slug = val.toLowerCase().replace(/ /g, '_')
      }
    },
    
    methods: {
        submit() {
            this.form.post(this.computedRoute, {

                // onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        },
        cancel() {
          history.back()
        }
    }
  }
</script>
