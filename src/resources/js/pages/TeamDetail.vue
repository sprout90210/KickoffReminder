<template>
  <div class="w-full text-gray-600">
    <div class="py-6 sm:py-10 flex flex-wrap justify-center items-center">
      <div class="p-2 sm:pl-16">
        <img
          :src="generateImgUrlDev(team.crest)"
          alt="crest"
          class="w-24 h-24 sm:h-32 sm:w-32"
        />
      </div>

      <div class="flex flex-col items-center sm:ml-20">
        <h1 class="pb-4 sm:py-6 sm:text-xl font-bold">{{ team.name }}</h1>
        <div class="flex text-xs items-center" v-if="team.venue">
          <img
            :src="generateImgUrlDev('stadium.png')"
            alt="stadium"
            class="h-6 w-5 mr-2"
          />
          <div>
            {{ team.venue }}
          </div>
        </div>
        <div class="flex h-9 justify-center m-4">
          <a
            v-if="team.twitter"
            :href="team.twitter"
            target="_blank"
            rel="noopener noreferrer"
            class="block w-9 h-9 mx-2 rounded-full"
          >
            <img
              :src="generateImgUrlDev('x.jpeg')"
              alt="twitter"
              class="rounded-full"
            />
          </a>
          <a
            v-if="team.youtube"
            :href="team.youtube"
            target="_blank"
            rel="noopener noreferrer"
            class="block w-9 h-9 mx-2 rounded-full"
          >
            <img
              :src="generateImgUrlDev('youtube.jpeg')"
              alt="youtube"
              class="rounded-full"
            />
          </a>
          <a
            v-if="team.instagram"
            :href="team.instagram"
            target="_blank"
            rel="noopener noreferrer"
            class="block w-9 h-9 mx-2 rounded-full"
          >
            <img
              :src="generateImgUrlDev('instagram.png')"
              alt="instagram"
              class="rounded-full"
            />
          </a>
        </div>
        <div class="text-sm" v-if="team.website">
          <span> Website : </span>
          <a
            :href="team.website"
            target="_blank"
            rel="noopener noreferrer"
            class="text-sky-500 underline"
          >
            {{ team.website }}
          </a>
        </div>
      </div>
    </div>
    <div class="flex border-b border-gray-300">
      <button
        @click="activeTab = 'standings'"
        class="px-4 sm:px-8 py-2 ml-3 sm:ml-6 rounded-t border border-b-0 text-sm"
        :class="{
          'bg-white font-bold hover:cursor-default border-gray-300':
            activeTab === 'standings',
          'bg-gray-200 hover:bg-sky-300 hover:text-white': activeTab !== 'standings',
        }"
      >
        順位
      </button>
      <button
        @click="activeTab = 'results'"
        class="px-4 sm:px-8 py-2 ml-2 rounded-t border border-b-0 text-sm"
        :class="{
          'bg-white font-bold hover:cursor-default border-gray-300':
            activeTab === 'results',
          'bg-gray-200 hover:bg-sky-300 hover:text-white': activeTab !== 'results',
        }"
      >
        結果
      </button>
      <button
        @click="activeTab = 'schedule'"
        class="px-4 sm:px-8 py-2 ml-2 rounded-t border border-b-0 text-sm"
        :class="{
          'bg-white font-bold hover:cursor-default border-gray-300':
            activeTab === 'schedule',
          'bg-gray-200 hover:bg-sky-300 hover:text-white': activeTab !== 'schedule',
        }"
      >
        予定
      </button>
    </div>
    <div class="h-80">
      <div v-if="activeTab === 'standings'">順位表を表示します</div>
      <div v-else-if="activeTab === 'results'">試合結果を表示します</div>
      <div v-else-if="activeTab === 'schedule'">試合スケジュールを表示します</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TeamDetail",

  data() {
    return {
      team: {},
      activeTab: "standings",
      s3Url: import.meta.env.VITE_AWS_S3_URL,
    };
  },

  computed: {
    teamId() {
      return this.$route.params.teamId;
    },
  },

  mounted() {
    this.getTeamDetail();
  },

  methods: {
    getTeamDetail() {
      axios
        .get(`/api/teams/${this.teamId}`)
        .then((res) => {
          this.team = res.data;
        })
        .catch((e) => {
          console.log(e);
        });
    },
    generateImgUrlDev(ImgName){
        const ImgUrl = '/images/' + ImgName;
        return ImgUrl;
    },
  },
};
</script>
