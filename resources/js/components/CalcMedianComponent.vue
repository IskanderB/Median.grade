<template>
    <div class="container_cust">
        <div class="close_box" v-bind:style="{display: fullResultDis}">
            <div class="close_icon">
                <i class="fa fa-times" aria-hidden="true" @click="changeWindow"></i>
            </div>
        </div>
        <form method="POST" class="appointment-form" id="appointment-form" v-bind:style="{display: formDis}">
            <h2>расчёт среднего балла</h2>
            <div class="form-group-1">
                <input type="text" name="first_name" id="title" placeholder="Имя" required />
                <input type="text" name="last_name" id="name" placeholder="Фамилия" required />
                <input type="email" name="otc" id="email" placeholder="Отчество" required />
                <input type="number" name="n_zach" id="phone_number" placeholder="Номер студенческого билета" required />
                <div class="select-list">
                    <select name="learn_type" id="course_type">
                        <option slected value="bak_spec">Бакалавриат/специалитет</option>
                        <option value="mag">Магистратура</option>
                    </select>
                </div>
            </div>
            <div class="form-check">
                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                <label for="agree-term" class="label-agree-term"><span><span></span></span>Я принимаю условия <a href="#" class="term-service">Пользовательского соглашения</a></label>
            </div>
            <div class="form-submit">
                <input type="submit" name="submit" id="submit" class="submit" value="Рассчитать" />
            </div>
        </form>
        <div class="result_wrap"  v-bind:style="{paddingTop: resPaddingTop}">
            <div class="diplom_box result_bits">
                <div class="result_bits_inner">
                    <span>Средний балл </span>
                    <span>зачётки: </span>
                    <span>4,78</span>
                </div>
            </div>
            <div class="diplom_box result_bits">
                <div class="result_bits_inner">
                    <span>Средний балл </span>
                    <span>диплома: </span>
                    <span>4,76</span>
                </div>
            </div>
            <div class="full_result_box" v-bind:style="{display: formDis}">
                <div class="full_result_btn" @click="changeWindow">Подробнее</div>
            </div>
        </div>
        <div class="grades_table_wrap" v-bind:style="{display: fullResultDis}">

        </div>
    </div>
</template>

<script>
    export default {
        data() {
    return {
      fullResultDis: "none",
      formDis: "block",
      resPaddingTop: "0px",
    };
  },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            changeWindow() {
                let change;
                change = this.fullResultDis;
                this.fullResultDis = this.formDis;
                this.formDis = change;
                if (this.resPaddingTop == "0px") {
                    this.resPaddingTop = "40px";
                }
                else {
                    this.resPaddingTop = "0px";
                }
            }
        }
    }
</script>
