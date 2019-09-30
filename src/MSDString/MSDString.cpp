// CreateTime: 2019-09-22 01:19:56
#include <iostream>
#include <cstdio>
#include <cstdlib>
#include <cstring>
#include <string>
#include <cmath>
#include <algorithm>
#include <queue>
#include <vector>
#include <stack>
#include <map>
#include <set>
#include <list>

using namespace std;

int myrand(int l, int r) {
    int n = rand();
    int m = (r-l)+1;
    return n % m + l;
}

char randomChar()
{
    return myrand(0, 25) + 'a';
}

string randomString(int len)
{
    string str = "";
    for (int i = 0; i < len; i++) {
        str += randomChar();
    }
    return str;
}

// radix 从 0 开始
int getDigitByRadix(string str, int radix)
{
    return radix >= str.size()? 0: (str[radix]) - 'a' + 1;
}

int getMaxLen(vector<string> &arr)
{
    int maxLen = 1;
    for (auto iter = arr.begin(); iter != arr.end(); iter++) {
        maxLen = max(maxLen, (int)iter->size());
    }
    return maxLen;
}

void sortedByRadix(vector<string> &arr, int maxStep, int step, int l, int r) {
    auto n = (r-l + 1);

    if (step > maxStep || n <= 1) {
        return;
    }

    auto maxRadix = 27;
    int mapper[28] = {0};
    vector<string> aux(arr.size());

    for (int i = l; i <= r; ++i) {
        auto digit = getDigitByRadix(arr[i], step);
        mapper[digit+1] += 1;
    }

    for (int i = 1; i < maxRadix; i++) {
        mapper[i] += mapper[i-1];
    }

    for (int i = l; i <= r; ++i) {
        auto digit = getDigitByRadix(arr[i], step);
        auto idx = mapper[digit]++;
        aux[idx] = arr[i];
    }

    for (int i = l; i <= r; i++) {
        arr[i] = aux[i-l];
    }

    auto lastCnt = 0;
    for (int i = 0; i < maxRadix; ++i) {
        auto cnt = mapper[i] - lastCnt;
        if (curCnt >= 1) {
            sortedByRadix(arr, maxStep, step+1, lastCnt, lastCnt + cnt-1);
            lastCnt += cnt;
        }
    }
}

void mysort(vector<string> &arr) {
    int maxRadix = getMaxLen(arr);
    sortedByRadix(arr, maxRadix-1, 0, 0, arr.size()-1);
}

int main(void) {
    srand(time(NULL));

    vector <string> arr;
    for (int i = 0; i < 5; i++) {
        string str = randomString(2);
        arr.push_back(str);
    }
    mysort(arr);
    // sort(arr.begin(), arr.end());

    for (int i = 0; i < 5; i++) {
        cout << arr[i] << endl;
    }

    return 0;
}

