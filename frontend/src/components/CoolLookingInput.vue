<script setup lang="ts">
import { CornerDownLeft, Mic, Paperclip } from 'lucide-vue-next'

import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip'
</script>

<template>
  <form class="relative overflow-hidden rounded-lg border bg-background focus-within:ring-1 focus-within:ring-ring">
    <Label for="message" class="sr-only">
      Message
    </Label>
    <Textarea
        id="message"
        placeholder="Type your message here..."
        class="min-h-12 resize-none border-0 p-3 shadow-none focus-visible:ring-0"
    />
    <div class="flex items-center p-3 pt-0">
      <TooltipProvider>
        <Tooltip>
          <TooltipTrigger as-child>
            <Button variant="ghost" size="icon">
              <Paperclip class="size-4" />
              <span class="sr-only">Attach file</span>
            </Button>
          </TooltipTrigger>
          <TooltipContent side="top">
            Attach File
          </TooltipContent>
        </Tooltip>
      </TooltipProvider>
      <TooltipProvider>
        <Tooltip>
          <TooltipTrigger as-child>
            <Button variant="ghost" size="icon">
              <Mic class="size-4" />
              <span class="sr-only">Use Microphone</span>
            </Button>
          </TooltipTrigger>
          <TooltipContent side="top">
            Use Microphone
          </TooltipContent>
        </Tooltip>
      </TooltipProvider>
      <Button type="submit" size="sm" class="ml-auto gap-1.5">
        Send Message
        <CornerDownLeft class="size-3.5" />
      </Button>
    </div>
  </form>
</template>