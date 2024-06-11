<script setup>
import api from "@/api.js";
import * as z from 'zod'
import {onMounted, ref} from 'vue'
import {useForm} from 'vee-validate'
import {toTypedSchema} from '@vee-validate/zod'
import {Button} from '@/components/ui/button'
import {FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage,} from '@/components/ui/form'
import {Input} from '@/components/ui/input'
import {Textarea} from '@/components/ui/textarea'
import {toast} from '@/components/ui/toast'
import router from "@/router.js";

const formSchema = toTypedSchema(
    z.object({
      course_name: z.string().min(2, 'Course name must be at least 2 characters').max(100, 'Course name must be less than 100 characters'),
      description: z.string().min(10, 'Description must be at least 10 characters').max(500, 'Description must be less than 500 characters')
    })
)

const initialValues = {
  course_name: '',
  description: ''
}

const { handleSubmit, setValues } = useForm({
  validationSchema: formSchema,
  initialValues
})

const onSubmit = handleSubmit(async (values) => {
  try {
    // Если мы редактируем курс
    if (isEditing.value) {
      // Отправляем запрос на обновление данных курса
      await api.put(`/courses/${courseId.value}`, values);
      toast({
        title: 'Success',
        description: 'Course updated successfully',
      })
    } else {
      // Если мы создаем новый курс
      // Отправляем запрос на создание нового курса
      await api.post('/courses', values)
      toast({
        title: 'Success',
        description: 'Course created successfully',
      })
    }
    // Переходим на страницу списка курсов
    router.go();
  } catch (error) {
    // В случае ошибки выводим уведомление
    toast({
      title: 'Error',
      description: isEditing.value ? 'Failed to update course' : 'Failed to create course',
    })
  }
})

const courseId = ref(null);
const isEditing = ref(false);

onMounted(() => {
  const routeParams = router.currentRoute.value.params;
  if (routeParams.id) {
    isEditing.value = true;
    courseId.value = routeParams.id;
    fetchCourse(routeParams.id);
  }
})

const fetchCourse = async (id) => {
  try {
    const response = await api.get(`/courses/${id}`);
    console.log(response.data.course_name)
    initialValues.course_name = response.data.course_name;
    initialValues.description = response.data.description;
    setValues({
      course_name: initialValues.course_name,
      description: initialValues.description,
    })
  } catch (error) {
    toast({
      title: 'Error',
      description: `Failed to fetch course: ${error}`,
    })
  }
}

const goBack =  () => {
  router.back();
}
</script>

<template>
  <form @submit="onSubmit" class="space-y-6">
    <FormField v-slot="{ field }" name="course_name">
      <FormItem>
        <FormLabel>Course Name</FormLabel>
        <FormControl>
          <Input type="text" placeholder="Enter course name" v-bind="field" />
        </FormControl>
        <FormDescription>
          Please provide the name of the course.
        </FormDescription>
        <FormMessage />
      </FormItem>
    </FormField>

    <FormField v-slot="{ field }" name="description">
      <FormItem>
        <FormLabel>Description</FormLabel>
        <FormControl>
          <Textarea placeholder="Enter course description" v-bind="field" />
        </FormControl>
        <FormDescription>
          Provide a detailed description of the course.
        </FormDescription>
        <FormMessage />
      </FormItem>
    </FormField>

    <Button class="mr-2" type="submit">
      {{ isEditing ? 'Update' : 'Create' }}
    </Button>
    <Button type="button" variant="secondary" @click="goBack()">
      Cancel
    </Button>
  </form>
</template>