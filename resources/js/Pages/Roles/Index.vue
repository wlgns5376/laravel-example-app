<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Roles
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="mb-3">
            <inertia-link :href="route('roles.create')" as="button" type="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                Create Role
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
                      Slug
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Permission
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                      <span class="sr-only">Action</span>
                    </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="role in roles" :key="role.slug">
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ role.name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      {{ role.slug }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span v-for="permission in role.permissions" :key="permission.id" class="inline-block rounded-full text-sm text-white px-3 bg-indigo-600 mr-2">{{ permission.name }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <inertia-link :href="route('roles.show', role.id)" as="button" type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition">Edit</inertia-link>
                      <jet-danger-button @click="doDelete(role.id)" class="ml-2">Delete</jet-danger-button>
                    </td>
                </tr>
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
    import { Inertia } from '@inertiajs/inertia'
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button'
    import JetDangerButton from '@/Jetstream/DangerButton'

    export default {
        components: {
            AppLayout,
            JetButton,
            JetDangerButton,
        },

        props: [
            'roles'
        ],

        methods: {
          doDelete(id) {
            if (confirm("삭제하시겠습니까?")) {
              Inertia.delete(this.route('roles.destroy', id), {
                preserveScroll: true,
              })
            }
          }
        }
    }
</script>
