<template>
    <div class="container_cust">
        <div class="close_box" v-bind:style="{display: fullResultDis}">
            <div class="close_icon">
                <i class="fa fa-times" aria-hidden="true" @click="changeWindow"></i>
            </div>
        </div>
        <div method="POST" class="appointment-form" id="appointment-form" v-bind:style="{display: formDis}">
            <h2>расчёт среднего балла</h2>
            <div class="form-group-1">
                <input maxlength="255" type="text" name="last_name" id="name" placeholder="Фамилия" required v-model="last_name" />
                <input maxlength="255" type="text" name="first_name" id="title" placeholder="Имя" required v-model="first_name" />
                <input maxlength="255" type="text" name="otc" id="email" placeholder="Отчество" required v-model="otc" />
                <input maxlength="255" type="text" name="n_zach" id="phone_number" placeholder="Номер студенческого билета" required v-model="n_zach" />
                <div class="select-list">
                    <select name="learn_type" id="course_type" v-model="learn_type">
                        <option slected value="bak_spec">Бакалавриат/специалитет</option>
                        <option value="mag">Магистратура</option>
                    </select>
                </div>
            </div>
            <div class="form-check">
                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required v-model="check_rules" />
                <label for="agree-term" class="label-agree-term" v-bind:style="{color: errorColor}"><span><span></span></span>Я согласен на обработку <a :href="`${rulesName}`" class="term-service" v-bind:style="{color: errorColor}">Персональных данных</a></label>
            </div>
            <div class="form-submit">
                <div name="submit" id="submit" class="submit" @click="getStudent">Рассчитать</div>
            </div>
            <div class="animation_cust">
                <div class='sk-chasing-dots'>
                  <div class='sk-child sk-dot-1'></div>
                  <div class='sk-child sk-dot-2'></div>
                </div>
            </div>
        </div>
        <div class="result_wrap"  v-bind:style="{paddingTop: resPaddingTop, display: openResult}">
            <div class="zach_box result_bits">
                <div class="result_bits_inner">
                    <span><i class="fa fa-hourglass-half" aria-hidden="true"></i></span>
                    <span>Средний балл </span>
                    <span>зачётки: </span>
                    <span>{{medianZach}}</span>
                </div>
            </div>
            <div class="diplom_box result_bits">
                <div class="result_bits_inner">
                    <span><i class="fa fa-graduation-cap" aria-hidden="true" v-bind:style="{color: colorDip}"></i></span>
                    <span>Средний балл </span>
                    <span>диплома: </span>
                    <span>{{medianDip}}</span>
                </div>
            </div>
            <div class="full_result_box" v-bind:style="{display: formDis}">
                <div class="full_result_btn" @click="changeWindow">Подробнее</div>
            </div>
        </div>
        <div class="error_wrap" v-bind:style="{display: erroeView}">
            <div class="error_box">
                <div class="error">
                    {{errorMessage}}
                </div>
            </div>
        </div>
        <div class="grades_table_wrap" v-bind:style="{display: fullResultDis}">
            <div class="limiter">
                <div class="container-table100" v-bind:style="{maxHeight: maxHeight}">
                    <div class="wrap-table100">
                        <div class="table100">
                            <table>
                                <thead>
                                    <tr class="table100-head">
                                        <th class="column1">Название</th>
                                        <th class="column2">Тип</th>
                                        <th class="column3">Оценка</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="iter in subjectsList">
                                            <td class="column1">{{iter.name}}</td>
                                            <td class="column2">{{iter.type}}</td>
                                            <td class="column3">
                                                <span v-if="iter.grade.all.length > 1">
                                                <span>{{iter.grade.all}}</span>
                                                <span> => </span>
                                                </span>
                                                <span class="end_grade">{{iter.grade.end}}</span>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
    return {
      rulesName: "",
      errorMessage: "",
      erroeView: "none",
      animView: "none",
      maxHeight: 0,
      colorDip: "",
      openResult: "none",
      errorColor: "",
      fullResultDis: "none",
      formDis: "block",
      resPaddingTop: "0px",
      first_name: "",
      last_name: "",
      otc: "",
      n_zach: "",
      learn_type: "bak_spec",
      check_rules: "",
      medianZach: "",
      medianDip: "",
      subjectsList: [],
    };
  },
        mounted() {
            this.rulesName = "/rules";
            this.maxHeight = String(document.documentElement.clientHeight * 0.65) + "px";
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
            },
            getStudent() {
                this.animView = "block";
                if (!this.check_rules) {
                    this.errorColor = "red";
                    return false;
                }
                this.errorColor = "";

                axios({
                    method: 'post',
                    url: 'http://median.grades.ru/api/v1/student',
                    params: {
                        'first_name': this.first_name,
                        'last_name': this.last_name,
                        'otc': this.otc,
                        'n_zach': this.n_zach,
                        'learn_type': this.learn_type,
                    }
                })
                .then((response) => {
                    this.erroeView = "none";
                    if (Number(response.data.dip) >= 4.75) {
                        this.colorDip = "red";
                    }
                    else {
                        this.colorDip = "blue";
                    }
                    this.openResult = "block";
                    this.medianZach = response.data.zach;
                    this.medianDip = response.data.dip;
                    this.subjectsList = response.data.total;
                    this.animView = "none";
                })
                .catch((error) => {
                    this.openResult = "none";
                    this.animView = "none";
                    this.errorMessage = this.pullMessage(error.response.data.data);
                    this.erroeView = "block";
                    console.log(this.pullMessage(error.response.data.data));
                });
            },
            pullMessage(obj) {
                let allowNames = [
                'last_name',
                'first_name',
                'otc',
                'n_zach',
                'learn_type',
                'notFound',
                ];

                let message;
                allowNames.forEach((element) => {
                    try{
                        if (obj[element]) {
                            message = obj[element][0];
                            return true;
                        }
                    }catch(e) {

                    }
                });
                return message;
            },
        }
    }
</script>
