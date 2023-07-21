<template>
    <div>
        <form class="forms-sample">
            <div class="form-group">
                <label>Select Category</label>
                <select class="form-control" v-model="category">
                    <option>Select</option>
                    <option v-for="(category,category_key) in question_categories" :value="category" :key="category_key">{{category.name}}</option>
                </select>
                <span v-if="errors.category">
                    <label id="question-error" class="error mt-2 text-danger" v-for="(msg,key) in errors.category" :key="key">{{msg}}</label>
                </span>
            </div>
            <div class="form-group">
                <label >Group Name</label>
                <input type="text" v-model="name" :class="errors ? 'has-danger' : ''" class="form-control" placeholder="Enter group name">
                <span v-if="errors.name">
                    <label id="question-error" class="error mt-2 text-danger" for="question" v-for="(msg,key) in errors.name" :key="key">{{msg}}</label>
                </span>
            </div>
            <div class="form-group">
                <label >Group Order (Positive integer e.g 1,2 etc)</label>
                <input type="number" v-model="order" :class="errors ? 'has-danger' : ''" class="form-control" placeholder="Enter group order">
                <span v-if="errors.order">
                    <label id="question-error" class="error mt-2 text-danger" for="question" v-for="(msg,key) in errors.order" :key="key">{{msg}}</label>
                </span>
            </div>

            <button @click="submit" type="button" v-if="!loading" class="btn btn-gradient-primary mr-2">Submit</button>
            <div v-if="loading" class="loader"></div>
        </form>
    </div>
</template>
<script>
export default {
    props:['question_categories'],
    data(){
        return{
            name:'',
            order:1,
            category:[],
            loading:false,
            errors:[],
        }
    },
    methods:{
        resetForm(){
           this.category = '';
           this.name = '';
           this.order = '';
           this.errors = [];
        },
        submit(){
            this.loading = true;
            var formdata = new FormData();
            formdata.append('category', this.category);
            formdata.append('name', this.name);
            formdata.append('order',this.order);
            axios.post('/questions-group/store',formdata)
            .then((response) => {
                this.loading = false;
                this.resetForm();
                swal('Success !','A new questions group has been added','success');
            }).catch((error) => {
                this.loading = false;
                if(error.response.status == '422'){
                    this.errors = error.response.data.errors;
                    swal('Error !','Please enter valid data.','error');
                }else{
                    swal('Error !','Something went wrong.Please try again later !!','error');
                }
            });
        }
    }
}
</script>
