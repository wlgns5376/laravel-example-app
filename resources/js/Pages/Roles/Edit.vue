<template>
  <admin-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Roles
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
          <div class="mb-4">
            <div class="text-base font-medium text-gray-900">Permissions</div>
            <ul>
              <li v-for="permission in permissions" :key="permission.slug">
                <input type="checkbox" :id="'permission_'+permission.slug" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" v-model="form.permissions" :value="permission.id" />
                <label :for="'permission_'+permission.slug" class="ml-3 text-sm font-medium text-gray-700">{{ permission.name }}</label>
              </li>
            </ul>
          </div>

          <div class="py-4">
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Create
            </jet-button>
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
      JetActionMessage,
    },
    props: {
      role: {
        type: Object,
        default: {}
      },
      permissions: Array,
    },
    data() {
      let permissions = this.role.permissions ? this.role.permissions.map(permission => permission.id) : [];
      return {
        form: useForm({
          _method: this.role.id ? "PUT" : "POST",
          name: this.role.name,
          slug: this.role.slug,
          permissions: permissions,
        }),
      }
    },
    computed: {
      computedRoute() {
        return this.role.id ? this.route('roles.update', this.role.id) : this.route('roles.store')
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
        }
    }
  }
</script>
