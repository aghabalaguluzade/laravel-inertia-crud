<template>
    <nav class="mt-6">
        <ul class="flex space-x-6">
            <li>
                <NavLink href="/" :active="$page.component === 'Home'">Home</NavLink>
            </li>
            <li>
                <NavLink href="/users" :active="$page.component === 'User'">Users</NavLink>
            </li>
            <li>
                <NavLink href="/settings" :active="$page.component === 'Settings'">Settings</NavLink>
            </li>
<!--            <li><Link href="/logout" method="POST" :data="{ data : 'foo' }" as="button" class="text-blue-500 hover:underline">Logout</Link></li>-->
        </ul>
    </nav>
</template>

<script>
import NavLink from "./NavLink.vue";

export default {
        components: {NavLink}
}
</script>

<style scoped>

</style>
