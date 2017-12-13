<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-body">

                <edit-password-form></edit-password-form>
            </div>
        </div>
    </div>
</template>

<script>
    import EditPasswordForm from './EditPasswordForm.vue'

    export default {
        name:'edit-password',
        components:{
            EditPasswordForm
        }
    }
</script>