<template>

    <div class="mt-20">
        <h1 class="mb-10 text-5xl font-bold flex items-center justify-center">
            <i class="button-special-text mr-2 fa-solid fa-chart-simple text-4xl"></i>
                Sales
            <br/>
        </h1>
        <div class="grid grid-cols-10 mx-10 gap-10">
            <top-selling :items="items" class="col-span-3"/>
            <div class="col-span-7">
                <div class="flex justify-between mb-4 font-semibold text-sm">
                    <div class="flex gap-x-3">
                        <Link :class="time != 'year' ? 'bg-white text-purple-500' : 'bg-purple-500 text-white'" :href="route('control_panel.sales.index', {time: 'year'})" class="button-primary-local">Yearly</Link>
                        <Link :class="time != 'month' ? 'bg-white text-purple-500' : 'bg-purple-500 text-white'" :href="route('control_panel.sales.index', {time: 'month'})" class="button-primary-local">Monthly</Link>
                        <Link :class="time != 'day' ? 'bg-white text-purple-500' : 'bg-purple-500 text-white'" :href="route('control_panel.sales.index', {time: 'day'})" class="button-primary-local">Daily</Link>
                    </div>
                    <div class="flex gap-x-3">
                        <button @click="switchChart('items_sold')" :class="chartValueShow != 'items_sold' ? 'bg-white text-purple-500' : 'bg-purple-500 text-white'" class="button-primary-local">products sold</button>
                        <button @click="switchChart('income')" :class="chartValueShow != 'income' ? 'bg-white text-purple-500' : 'bg-purple-500 text-white'" class="button-primary-local">income</button>
                    </div>
                </div>
                <canvas id="myChart"></canvas>
                <div class="flex flex-col gap-y-4">
                    <h2 class="font-bold text-2xl pt-8 pb-4">
                        <i class="fa-solid fa-shopping-bag text-purple-500 text-xl mr-2"></i>
                        Orders
                    </h2>
                    <order v-for="order in orders" :order="order" :key="order.id"/>
                </div>
            </div>
        </div>
        
    </div>
</template>

<style scoped>

.button-primary-local{
    padding: 5px 10px;
    border-radius: 10px;
    display: flex;
    align-items:center;
    gap: 10px;
    border: solid 2px #a855f7;
    transition: 0.1s ease-in;
}

</style>

<script setup>

    import Order from "@/Components/ControlPanelSales/SalesOrder.vue"
    import Chart from 'chart.js/auto';
    import { onMounted, ref, computed } from 'vue'
    import { Link } from '@inertiajs/vue3'
    import TopSelling from '@/Components/ControlPanelSales/TopSelling.vue'

    const props = defineProps({
        orders: Object,
        items: Object,
        time: String,
    })

    const chartData = ref([])
    const chartInstance = ref(null)
    const chartValueShow = ref('income');

    const chartDataShow = computed(()=>chartData.value.map(el => el[chartValueShow.value]));

    const getDaysInMonth = () => {
        const currentDate = new Date();
        const nextMonthFirstDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
        let result = [];

        for(let i=1; i <= nextMonthFirstDay.getDate(); i++){
            result.push(String(i))
        };
        return result;
    }

    const timeLabels = {
        day: ['0:00', '3:00', '6:00', '9:00', '12:00', '15:00', '18:00', '21:00', '24:00'],
        month: getDaysInMonth(),
        year: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    }

    const getIndex = (order) => {
        let orderDate = new Date(order.created_at)
        let result = 0;
        switch(props.time){
            case 'day':
                result = Math.floor(orderDate.getHours()/3);
                break;
            case 'month':
                result = orderDate.getDate();
                break;
            case 'year':
                result = orderDate.getMonth();
                break;
        }
        if(props.time == 'month'){
            --result;
        } 
        return result;
    }

    const placeOrderInChartData = (order) => {
        let index = getIndex(order);
        if(chartData.value[index]){
            order.cart.cart_items.forEach(
                cartItem => {
                    chartData.value[index]['items_sold'] += cartItem.amount
                }
            )
            chartData.value[index]['income'] += order.payment.price;
        } else {
            let items_sold = 0;
            order.cart.cart_items.forEach(
                cartItem => {
                    items_sold += cartItem.amount
                }
            )
            chartData.value[index] = {
                items_sold: items_sold,
                income: order.payment.price
            }
        }
    }

    chartData.value[getIndex({created_at: new Date()})] = {income: 0, items_sold: 0};
    props.orders.forEach(order => {
        placeOrderInChartData(order);
    })
    
    for(let i=0; i<chartData.value.length-1; i++){
        if(!chartData.value[i]){
            chartData.value[i] = {income: 0, items_sold: 0}
        }
    }

    const switchChart = (value) => {
        if(value != chartValueShow.value){
            chartValueShow.value = value;
            createChart();
        }
    }

    const createChart = () => {
        const ctx = document.getElementById('myChart');
        if (chartInstance.value) {
            chartInstance.value.destroy()
        }
        
        chartInstance.value = new Chart(ctx, {
            type: 'line',
            options: {
                borderColor: '#a855f7',
                responsive: true,
                animation: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                scales: {
                    y: {
                        min: 0,
                    },
                    x: {
                        ticks: props.time == 'month' 
                        ? {
                            callback: function(val, index) {
                                // Hide every 2nd tick label
                                return index % 3 === 0 ? this.getLabelForValue(val) : '';
                            },
                        } 
                        : {
                            callback: function(val) {
                                return this.getLabelForValue(val)
                            },
                        },
                    }
                }
            },
            data: {
                labels: timeLabels[props.time],
                datasets: [{
                    label: chartValueShow.value,
                    data: chartDataShow.value
                }]
            },
        })
    }

    onMounted(
        ()=>{
            createChart();
        }
    )

</script>