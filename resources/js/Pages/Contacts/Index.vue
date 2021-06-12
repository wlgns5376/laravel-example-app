<template>
  <admin-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Contacts
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-3">
            <inertia-link :href="route('contacts.create')" as="button" type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                Create Contact
            </inertia-link>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Created At
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                      <span class="sr-only">Action</span>
                    </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="contact in contacts" :key="contact.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                          <img class="h-10 w-10 rounded-full" :src="contact.profile_photo_url" :alt="contact.name" />
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            {{ contact.name }}
                          </div>
                          <div class="text-sm text-gray-500">
                            {{ contact.email }}
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ contact.role ? contact.role.name : '' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ contact.created_at }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <inertia-link :href="route('contacts.show', contact.id)" as="button" type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">Edit</inertia-link>
                      <jet-danger-button @click="doDelete(contact.id)" class="ml-2">Delete</jet-danger-button>
                    </td>
                </tr>
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </admin-layout>
</template>

<script>
    import { Inertia } from '@inertiajs/inertia'
    import AdminLayout from '@/Layouts/AdminLayout'
    import JetButton from '@/Jetstream/Button'
    import JetDangerButton from '@/Jetstream/DangerButton'

    export default {
        components: {
            AdminLayout,
            JetButton,
            JetDangerButton,
        },

        props: [
            'contacts'
        ],

        methods: {
          doDelete(id) {
            if (confirm("삭제하시겠습니까?")) {
              Inertia.delete(this.route('contacts.destroy', id), {
                preserveScroll: true,
              })
            }
          }
        }
    }
</script>
