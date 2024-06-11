<script>
import api from '@/api.js';
import Footer from "@/components/Footer.vue";
import CourseForm from "@/components/admin/CourseForm.vue";
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea'
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion'
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { useToast } from '@/components/ui/toast/use-toast';
import router from '@/router.js';

const { toast } = useToast();

export default {
  components: {
    Footer,
    CourseForm,
    Button,
    Label,
    Input,
    Textarea,
    Accordion, AccordionContent, AccordionItem, AccordionTrigger,
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
  },
  data() {
    return {
      courses: [],
      newCourse: {
        course_name: '',
        description: ''
      },
    };
  },
  async created() {
    await this.fetchCourses();
  },
  methods: {
    async fetchCourses() {
      try {
        const response = await api.get('/courses');
        this.courses = response.data;
      } catch (error) {
        console.error('Failed to fetch courses:', error);
      }
    },
    viewCourse(id) {
      router.push(`/courses/${id}`);
    },
    editCourse(id) {
      router.push(`/admin/courses/edit/${id}`);
    },
    async deleteCourse(id) {
      try {
        await api.delete(`/courses/${id}`);
        toast({
          description: 'Course deleted successfully!',
        });
        await this.fetchCourses();
      } catch (error) {
        console.error('Failed to delete course:', error);
        toast({
          description: 'Failed to delete course.',
          variant: 'error'
        });
      }
    },
  },
};
</script>

<template>
  <div class="relative sm:flex flex-col sm:justify-center sm:items-center min-h-screen selection:bg-red-500 selection:text-white">
    <span class="m-8 font-semibold text-5xl text-gray-800 leading-tight">
      Courses Management
    </span>

    <div class="container mx-auto w-3/5 p-4 text-xl">
      <Accordion type="single" collapsible class="w-full">
        <AccordionItem value="item-1">
          <AccordionTrigger>Create New Course</AccordionTrigger>
          <AccordionContent class="flex justify-center items-center">
            <div class="w-full max-w-md">
              <CourseForm/>
            </div>
          </AccordionContent>
        </AccordionItem>
      </Accordion>
    </div>

    <h2 class="mt-10 scroll-m-20 pb-2 text-3xl font-semibold tracking-tight transition-colors first:mt-0">
      Courses:
    </h2>

    <ul class="mb-16">
      <li v-for="course in courses" :key="course.id" class="p-8 bg-white rounded">
        <h3 class="scroll-m-20 text-2xl font-semibold tracking-tight">
          {{ course.course_name }}
        </h3>
        <p class="leading-7 mt-2">
          {{ course.description }}
        </p>
        <div class="flex space-x-3 mt-3">
          <Button @click="viewCourse(course.id)">View</Button>
          <Button @click="editCourse(course.id)" variant="outline">Edit</Button>
          <AlertDialog>
            <AlertDialogTrigger>
              <Button variant="destructive">Delete</Button>
            </AlertDialogTrigger>
            <AlertDialogContent>
              <AlertDialogHeader>
                <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                <AlertDialogDescription>
                  This action cannot be undone. This will permanently delete
                  course and remove your data from our servers.
                </AlertDialogDescription>
              </AlertDialogHeader>
              <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <AlertDialogAction class="bg-destructive hover:bg-destructive" @click="deleteCourse(course.id)">Delete</AlertDialogAction>
              </AlertDialogFooter>
            </AlertDialogContent>
          </AlertDialog>
        </div>
      </li>
    </ul>
  </div>
  <div class="h-6"></div>
  <Footer/>
</template>


