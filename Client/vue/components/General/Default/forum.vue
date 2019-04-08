<template>
    <div class="">
        <section class="section">
         <div class="container">
             <div class="card">
           <div class="card-content">
               <h4 class="title">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aliquid, maiores!</h4> 
           </div>
        </div>
        <div class="forum_content">
            <div class="forum_button">
                <a href="" class="button">New</a>
                <a href="" class="button">Most post</a>
                <a href="" class="button">Lastest</a>
            </div>
        <div class="thread_display">
      <div class="info_tooltip avatar_icon thread_display__icon">
    <div class="info_tooltip__content">
        <div class="avatar_icon__header">
        <div class="avatar_icon__icon avatar_icon__icon--small picture_circle"
         style="background-color: rgb(23, 252, 138);">
					A
		</div>
            <div class="avatar_icon__header_info">
                     <span class="avatar_icon__username">
						dqwdqd</span>
                <span class="avatar_icon__date">User since 02/01/2019</span>
              </div>
         </div>
      </div> 
         <div class="info_tooltip__display">
    <div class="avatar_icon__icon picture_circle avatar_icon__icon--small" style="background-color: rgb(239, 252, 138);">D
	</div>
    </div>
    </div>
            <!-- show hidden -->
            <div class="content">
                <div class="thread_display__header">

             
            <span class="header_name">Jonh</span>
            <div class="header_meta_bar">
             <div>
                         By
           <span class="thread_display__username">
               Chicken
           </span>
           In 
           <span>Bugs</span>.
           <span class="thread_display__date">22/1/2109</span>
             </div>
            </div>
            </div>
                <div class="thread_display__replies_bar">
                <span>No Replay</span>
                <div class="thread_display__replies">
                    <span>0</span>
                </div>
            </div>
            <div class="thread_display__content">
              Lorem ipsum dolor sit amet.
            </div>
   </div>
        </div>
        </div>

<!-- Replay -->
<div class="thread_display">
    <div class="info_tooltip avatar_icon thread_display__icon">
    <div class="info_tooltip__content">
        <div class="avatar_icon__header">
        <div class="avatar_icon__icon avatar_icon__icon--small picture_circle"
         style="background-color: rgb(239, 252, 138);">
					D
		</div>
            <div class="avatar_icon__header_info">
                     <span class="avatar_icon__username">
						dqwdqd</span>
                <span class="avatar_icon__date">User since 02/01/2019</span>
              </div>
         </div>
      </div> 
         <div class="info_tooltip__display">
    <div class="avatar_icon__icon picture_circle avatar_icon__icon--small" style="background-color: rgb(239, 252, 138);">D
	</div>
    </div>
    </div>
     <div style="width: 100%;">
         <div  class="thread_display__header">
             <span class="thread_display__name">
        test123123
    </span>
        <div class="thread_display__meta_bar">
            <div >
            By
            <span class="thread_display__username">dqwdqd</span> in
            <span class="thread_display__category">Bugs</span> ·
            <span  class="thread_display__date">02/01/2019</span>
            </div>
            </div>
            </div>
                <div class="thread_display__replies_bar">
                <div  class="thread_display__latest_reply">
                 <span  class="fa fa-reply fa-fw"></span> 
                 <span  class="thread_display__latest_reply__text">Latest reply by</span>
                 <span class="thread_display__username">Black_</span>	·
        <span  class="thread_display__date">8 hours ago</span></div>
         <div title="Replies to thread" class="thread_display__replies">
            <span class="fa fa-comment-o fa-fw"></span>2
			</div>
            </div>
             <div class="thread_display__content">
			test post
		</div>
        </div>
        </div>
         </div>
        </section>
    </div>
</template>
<script>
export default {
      created(){
this.$utils.windowNavigator(`Forum | ${this.s.site_name}`);
  }
}
</script>
<style scoped>

</style>

