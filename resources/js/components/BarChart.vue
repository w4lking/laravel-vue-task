<!-- src/components/BarChart.vue -->
<script setup lang="ts">
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

interface Props {
  data: Array<{ name: string; count: number }>
  label: string
}

const props = defineProps<Props>()

const chartData = {
  labels: props.data.map((item) => item.name),
  datasets: [
    {
      label: props.label,
      data: props.data.map((item) => item.count),
      backgroundColor: '#2563eb',
      borderRadius: 4,
    },
  ],
}

const options = {
  responsive: true,
  plugins: {
    legend: { display: true },
    title: { display: false },
  },
}
</script>

<template>
  <Bar :data="chartData" :options="options" />
</template>
