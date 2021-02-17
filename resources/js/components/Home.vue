<template>
<div class="home-container">
    <div style="background:#ECECEC; padding:30px">
        <a-card :bordered="false" style="width: 100%" >
            <div style="background-color: #F5F5F5; padding: 24px;">
                <a-page-header
                    :ghost="false"
                    title="Title"
                    sub-title="This is a subtitle"

                >
                    <template slot="extra">
                        <a-button key="3" type="link">
                           <router-link :to="{name:'login'}">
                               Login
                           </router-link>
                        </a-button>
                        <a-button key="2" type="link">
                            <router-link :to="{name:'register'}">
                                Register
                            </router-link>
                        </a-button>

                    </template>
                    <a-descriptions size="small" :column="3">
                        <a-descriptions-item label="Created">
                            Lili Qu
                        </a-descriptions-item>
                        <a-descriptions-item label="Association">
                            <a>421421</a>
                        </a-descriptions-item>
                        <a-descriptions-item label="Creation Time">
                            2017-01-10
                        </a-descriptions-item>
                        <a-descriptions-item label="Effective Time">
                            2017-10-10
                        </a-descriptions-item>
                        <a-descriptions-item label="Remarks">
                            Gonghu Road, Xihu District, Hangzhou, Zhejiang, China
                        </a-descriptions-item>
                    </a-descriptions>
                </a-page-header>
            </div>
            <p>
                <a-row>
                        <a-col :span="10" class="inventory-desc">
                           <span>
                               <strong class="homepage-title">Inventory Management</strong>
                               <br/>
                               <span class="homepage-text">

                                   Lorem ipsum dolor sit amet,
                                        consectetur adipiscing elit. In eget odio consectetur,
                                        vestibulum nisi eget, euismod mi. Nunc sit amet vulputate justo.
                                        Quisque ut pellentesque nibh, sit amet tincidunt ante. Ut eleifend justo eros,
                                        et faucibus quam pellentesque ut. Nunc dignissim maximus justo in pellentesque.
                                        Nunc bibendum metus sollicitudin nunc tristique feugiat.
                                        Phasellus feugiat ut mi ac sagittis.
                               </span>
                           </span>
                        </a-col>
                       <a-col :span="14">
                            <img src="images/homepage.jpg" alt="" style="width: 70%; height: 4%; margin-left: 2%"/>
                       </a-col>
               </a-row>
           </p>

        </a-card>
    </div>
</div>


</template>

<script>
export default {
    data(){
        return{

        }
    },

    mounted() {
    }
}
</script>
<style scoped>

.home-container{
    margin: 0;
    padding: 0;

}
tr:last-child td {
    padding-bottom: 0;
}
.inventory-desc{
    margin-top: 9%;

}
.homepage-title{
margin-left: 5rem;
}
.homepage-text{

}
</style>
