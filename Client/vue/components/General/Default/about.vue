<template>
  <div>
      <section class="section">
        <div class="container">
          <div class="about-content">
              <div class="content" v-if="!$utils.isEmptyVar(homeData.AboutJaol)">
                <p v-html="homeData.AboutJaol.description"></p>
              </div>
          </div>
            </div>
      </section>
    </div>
</template>
<script>
import Base from "@com/Bases/GeneralBase.js";
export default Base.extend({
  created() {
    this.fetchHomeData();
    this.setPageTitle(`About us`);
  }
});
</script>
