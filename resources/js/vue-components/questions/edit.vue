<template>
    <div>
        <form class="forms-sample">
            <div class="form-group">
                <label for="question">Question</label>
                <textarea rows="5" v-model="question" :class="errors.question ? 'has-danger' : ''" class="form-control" id="question"></textarea>
                <span v-if="errors.question">
                    <label id="question-error" class="error mt-2 text-danger" for="question" v-for="(msg,key) in errors.question" :key="key">{{msg}}</label>
                </span>
            </div>
            <div class="form-group">
                <label for="explanation">Explanation</label>
                <textarea rows="5" v-model="explanation" :class="errors.explanation ? 'has-danger' : ''" class="form-control" id="explanation"></textarea>
                <span v-if="errors.explanation">
                    <label id="explanation-error" class="error mt-2 text-danger" for="explanation" v-for="(msg,key) in errors.explanation" :key="key">{{msg}}</label>
                </span>
            </div>
            <div class="form-group">
                <label for="type">Question Type</label>
                <select class="form-control" v-model="type" @change="typeChanged" id="type">
                    <option>Text Answer</option>
                    <option>Single Answer Choice</option>
                    <option>Multiple Answer Choice</option>
                    <option>Rating Answer</option>
                </select>
            </div>
            <section v-if="type == 'Single Answer Choice' || type == 'Multiple Answer Choice'">
                <span v-if="errors.options">
                    <label class="error mt-2 text-danger" v-for="(msg,option_error_key) in errors.options" :key="option_error_key">{{msg}}</label>
                </span>
                <div class="row" v-for="(option,key) in options" :key="key">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button @click="removeOption(key)" type="button" class="btn btn-gradient-danger btn-sm mr-2">Remove Option</button>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label >Option {{key+1}} Text</label>
                            <input type="text" v-model="option.text" :class="errors['options.'+key+'.text'] ? 'has-danger' : ''" class="form-control" placeholder="Enter text">
                            <span v-if="errors['options.'+key+'.text']">
                                <label class="error mt-2 text-danger" v-for="(msg,err_key) in errors['options.'+key+'.text']" :key="err_key"  v-text="msg"></label>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Related Habits</label>
                            <select class="form-control" @change="habbitSelected($event.target.value,key)">
                                <option>Select</option>
                                <option v-for="(habbit,habbit_key) in habbits" :value="habbit.id" :key="habbit_key">{{habbit.name}}</option>
                            </select>
                            <span class="badge badge-dark m-2" v-for="(added_habbit,added_habbit_key) in option.related_habbits" :key="added_habbit_key">{{added_habbit.name}} <i class="mdi mdi-delete-forever text-danger" style="cursor:pointer;" @click="deleteHabbit(key,added_habbit_key)"></i></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                    <button @click="addOption" type="button" class="btn btn-gradient-info btn-md mr-2">Add Option</button>
                    </div>
                </div>
            </section>
            <button @click="submit" type="button" v-if="!loading" class="btn btn-gradient-primary mr-2">Submit</button>
            <div v-if="loading" class="loader"></div>
        </form>
    </div>
</template>
<script>
export default {
    props:['habbits','question_old'],
    data(){
        return{
            question:'',
            explanation:'',
            errors:[],
            loading:false,
            type:'Text Answer',
            options:[],
        }
    },
    mounted(){
        this.setOldData();
    },
    methods:{
        setOldData(){
            this.question = this.question_old.question;
            this.explanation = this.question_old.explanation;
            this.type = this.question_old.type;
            var old_options = this.question_old.options;
            var options = [];
            old_options.forEach((opt) => {
                var option_obj = {'id':opt.id,'text': opt.text,'related_habbits':[]};
                var related_habbits = [];
                var habbit_ids = opt.related_habbits.split(",");
                if(habbit_ids.length > 0){
                    habbit_ids.forEach((habb_id) => {
                        var habbit_obj = {'id' : '','name' : ''};
                        var habbit_original = this.habbits.find((habbit) => habbit.id == habb_id);
                        if(habbit_original){
                            related_habbits.push({'id' : habbit_original.id,'name' : habbit_original.name});
                        }
                    })
                }
                option_obj.related_habbits = related_habbits;
                options.push(option_obj);
            })
            this.options = options;
        },
        removeOption(key){
            this.options.splice(key,1);
        },
        addOption(){
            this.options.push({'id':'','text' : '','related_habbits' : []});
        },
        deleteHabbit(key,habbit_key){
            this.options[key].related_habbits.splice(habbit_key,1);
        },
        habbitSelected(habbit_id,key){
            if(habbit_id != 'Select'){
                var option = this.options[key];
                var is_exist = option.related_habbits.find((habbit) => habbit.id == habbit_id);
                if(!is_exist){
                    var habbit = this.habbits.find((habbit) => habbit.id == habbit_id);
                    if(habbit){
                        this.options[key].related_habbits.push({'id' : habbit.id,'name' : habbit.name});
                    }
                }
            }
        },
        typeChanged(e){
            var type = e.target.value;
            this.options = [];
            if(type == 'Single Answer Choice' || type == 'Multiple Answer Choice'){
                this.options.push({'text' : '','related_habbits' : []});
                this.options.push({'text' : '','related_habbits' : []});
            }
        },
        submit(){
            this.loading = true;
            var formdata = new FormData();
            formdata.append('id', this.question_old.id);
            formdata.append('question', this.question);
            formdata.append('explanation', this.explanation);
            formdata.append('type',this.type);
            formdata.append('options', JSON.stringify(this.options));
            axios.post('/questions/update',formdata)
            .then((response) => {
                this.loading = false;
                swal('Success !','Question has been updated successfully','success');
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
