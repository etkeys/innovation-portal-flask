#!/bin/bash

pushd ../JavaTestServer

./gradlew runJamMock -PappArgs="['--port', '10000']" &