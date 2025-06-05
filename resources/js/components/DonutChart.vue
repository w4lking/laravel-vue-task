<!-- src/components/DonutChart.vue -->
<script setup lang="ts">
import { Pie } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, ArcElement)

interface Props {
  data: Array<{ name: string; total: number }>
  colors: string[]
}

const props = defineProps<Props>()

const chartData = {
  labels: props.data.map((item) => item.name),
  datasets: [
    {
      label: 'Tasks',
      data: props.data.map((item) => item.total),
      backgroundColor: props.colors,
    },
  ],
}

const options = {
  responsive: true,
  plugins: {
    legend: {
      position: 'bottom' as const,
    },
    title: {
      display: false,
    },
  },
}
</script>

<template>
  <Pie :data="chartData" :options="options" />
</template>
