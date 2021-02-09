<template>
<div class="home-container">
    <div style="background:#ECECEC; padding:30px">
        <a-card :bordered="false" style="width: 100%" >
            <div style="background-color: #F5F5F5; padding: 24px;">
                <a-page-header
                    :ghost="false"
                    title="Title"
                    sub-title="This is a subtitle"
                    @back="() => $router.go(-1)"
                >
                    <template slot="extra">
                        <a-button key="3">
                           <router-link :to="{name:'login'}">
                               Login
                           </router-link>
                        </a-button>
                        <a-button key="2">
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
            <p>Card content</p>
            <p>Card content</p>
            <p>Card content</p>
        </a-card>
    </div>
</div>


</template>
<style>

.home-container{
    margin: 0;
    padding: 0;

}
tr:last-child td {
    padding-bottom: 0;
}
</style>
