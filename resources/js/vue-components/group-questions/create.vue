<template>
    <div>
        <div class="card-header bg-gradient-primary text-white mb-2">
            <p>Group Name : {{group.name}}</p>
            <p>Order : {{group.order}}</p>
            <p>Category : {{group.category}}</p>
            <p>Total Questions : {{group.group_questions.length}}</p>
        </div>
        <button type="button" v-if="group.group_questions.length == 0" data-toggle="modal" data-target="#add-question" class="btn btn-gradient-primary btn-sm mr-2" >Add Question</button>
        <div v-else>
            <div class="border my-2" v-for="(g_question,g_question_key) in group.group_questions" :key="g_question_key">
            <div class="bg-gradient-primary p-2" v-if="g_question.prev_option && g_question.prev_question">
               <span class="text-dark">For question : </span> <span class="text-info">{{g_question.prev_question.question.question}}</span> <br>
               <span class="text-dark">and option : </span> <span class="text-info">{{g_question.prev_option.option.text}}</span>
            </div>
            <div class="p-4">
                <p>Question {{g_question_key + 1}} : </p>
                <p v-text="g_question.question.question"></p>
                <ul class="my-2" v-if="g_question.group_question_options.length > 0">
                    <li class="py-2" v-for="(option,option_key) in g_question.group_question_options" :key="option_key">
                        <div @click="setOption(option)"  class="bg-gradient-dark px-2 text-white d-flex justify-content-between cursor-pointer" >{{option.option.text}}
                            <span >Next Question<i class="mdi mdi-arrow-right"></i></span>
                        </div>
                        <div class="p-2 border" v-if="option_selected.id == option.id">
                            <div v-if="option.next_question">
                                Next Question :
                                <p >{{option.next_question.question.question}}</p>
                            </div>
                            <div v-else class="p-2">
                                <button data-toggle="modal" data-target="#add-question" class="btn btn-sm btn-gradient-primary">Add Next <i class="mdi mdi-plus"></i></button>
                            </div>
                        </div>

                    </li>
                </ul>
                </div>
            </div>
        </div>
        <div class="modal fade" ref="close" id="add-question" tabindex="-1" role="dialog" aria-labelledby="add-question" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="view-habbit-modal">Add Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample">
                        <div class="form-group">
                            <p v-if="option_selected">
                                Option : {{option_selected.option.text}}
                            </p>
                            <vue-select label="question" :options="questions" v-model="current_question_selected" ></vue-select>
                            <span v-if="errors.question">
                                <label id="question-error" class="error mt-2 text-danger" for="question" v-for="(msg,key) in errors.question" :key="key">{{msg}}</label>
                            </span>
                            <div v-if="current_question_selected">
                                <ul class="my-2" v-if="current_question_selected.options.length > 0">
                                    <li class="py-2" v-for="(option,option_key) in current_question_selected.options" :key="option_key">
                                        <button class="btn btn-gradient-info btn-sm btn-block d-flex justify-content-between">{{option.text}} </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button @click="submit" type="button" v-if="!loading" class="btn btn-gradient-primary mr-2" >Submit</button>
                        <div v-if="loading" class="loader"></div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
export default {
    props:['group_main','questions','question_categories'],
    components:{
        'vue-select' : vSelect
    },
    data(){
        return{
            groupp:'',
            loading:false,
            errors:[],
            current_question_selected:'',
            option_selected:'',
        }
    },
    mounted(){
        this.groupp = this.group_main;
    },
    computed:{
        group(){
            if(this.groupp){
                return this.groupp;
            }else{
                return this.group_main;
            }
        },
        groupQuestions(){

        }
    },
    methods:{
        setOption(option){
           if(this.option_selected.id == option.id){
               this.option_selected = '';
           }else{
               this.option_selected = option;
           }
        },
        resetForm(){
           this.errors = [];
           this.current_question_selected = '';
           this.option_selected = '';
        },
        submit(){
            this.loading = true;
            var formdata = new FormData();
            formdata.append('group_id', this.group.id);
            formdata.append('question_id',this.current_question_selected.id);
            if(this.option_selected){
                formdata.append('group_question_option_id',this.option_selected.id);
                formdata.append('prev_group_question_id',this.option_selected.group_question_id);
            }
            axios.post('/group-questions/store',formdata)
            .then((response) => {
                this.loading = false;
                this.groupp = response.data.group;
                this.resetForm();
                this.$refs.close.click();
                if(response.data.msg){
                    if(response.data.msg == 'exist'){
                        swal('Success !','Question already added for this option','success');
                    }
                }else{
                    swal('Success !','A new group question has been added','success');
                }
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
<style>
.cursor-pointer{
    cursor: pointer;
}
</style>
