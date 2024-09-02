<template>
  <div class="btn-group" role="group">
    <a :href="getShowUrl(url,id)" class='btn btn-link'><i class="far fa-eye"></i></a>
    <a :href="getEditUrl(url,id)" class='btn btn-link'><i class="fas fa-edit"></i></a>
    <form :action="url + '/' + id" method="POST">
      <input type="hidden" name="_method" value="DELETE">
      <input type="hidden" name="_token" :value="token">
      <button class ="btn btn-danger btn-xs" type="submit" onclick="return confirm('¿Está seguro?')"><i class="fas fa-trash-alt"></i></button>
    </form>
  </div>
</template>
<script>
    export default {
        mounted() {
            console.log('ABM Component mounted.')
        },
        props: ['url','id','token'],
        methods: {
          getShowUrl: function (url,id){
            return url + "/" + id;
          },
          getEditUrl: function (url,id){
            return url + "/" + id + "/edit";
          }
        }
    }
</script>
