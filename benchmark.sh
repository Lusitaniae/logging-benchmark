#!/bin/bash
# Run benchmark test at multiple levels of concurrency
# and compare results

FILE_LOG_URL="http://localhost/?driver=fs&nr_tasks=4"
REDIS_LOG_URL="http://localhost/?driver=redis&nr_tasks=4"
REQUESTS_COUNT=10000

function print_difference
{
  DIFFERENCE=$(bc <<< "scale=2; ($1 - $2)/$2 * 100")
  echo $DIFFERENCE% - redis: $1 file: $2
}

echo "## TEST 1 ##"
CONCURRENCY=50
echo "Concurrency: $CONCURRENCY "
JOB_REDIS=$(ab -n $REQUESTS_COUNT -c $CONCURRENCY -q "$REDIS_LOG_URL"  | grep 'Requests per second' | awk '{print $4}')
JOB_FILE=$(ab -n $REQUESTS_COUNT -c $CONCURRENCY -q "$FILE_LOG_URL"  | grep 'Requests per second' | awk '{print $4}')
print_difference $JOB_REDIS $JOB_FILE
echo

echo "## TEST 2 ##"
CONCURRENCY=200
echo "Concurrency: $CONCURRENCY "
JOB_REDIS=$(ab -n $REQUESTS_COUNT -c $CONCURRENCY -q "$REDIS_LOG_URL"  | grep 'Requests per second' | awk '{print $4}')
JOB_FILE=$(ab -n $REQUESTS_COUNT -c $CONCURRENCY -q "$FILE_LOG_URL"  | grep 'Requests per second' | awk '{print $4}')
print_difference $JOB_REDIS $JOB_FILE
echo

echo "## TEST 3 ##"
CONCURRENCY=400
echo "Concurrency: $CONCURRENCY "
JOB_REDIS=$(ab -n $REQUESTS_COUNT -c $CONCURRENCY -q "$REDIS_LOG_URL"  | grep 'Requests per second' | awk '{print $4}')
JOB_FILE=$(ab -n $REQUESTS_COUNT -c $CONCURRENCY -q "$FILE_LOG_URL"  | grep 'Requests per second' | awk '{print $4}')
print_difference $JOB_REDIS $JOB_FILE
echo

echo "## TEST 4 ##"
CONCURRENCY=600
echo "Concurrency: $CONCURRENCY "
JOB_REDIS=$(ab -n $REQUESTS_COUNT -c $CONCURRENCY -q "$REDIS_LOG_URL"  | grep 'Requests per second' | awk '{print $4}')
JOB_FILE=$(ab -n $REQUESTS_COUNT -c $CONCURRENCY -q "$FILE_LOG_URL"  | grep 'Requests per second' | awk '{print $4}')
print_difference $JOB_REDIS $JOB_FILE
echo
